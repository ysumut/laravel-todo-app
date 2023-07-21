<?php

namespace App\Services;

class DeveloperService
{
    private WorkService $workService;

    public function __construct(WorkService $workService)
    {
        $this->workService = $workService;
    }

    private const MAX_WORKABLE_MINUTES_A_WEEK = 45 * 60;

    /**
     * Time in minutes for developers to do level 1 work
     */
    private const DEVELOPERS = [
        'DEV1' => 60,
        'DEV2' => 30,
        'DEV3' => 20,
        'DEV4' => 15,
        'DEV5' => 12,
    ];

    /**
     * @return array
     */
    public function calculateWorkPlan(): array
    {
        $works = $this->workService->getWorks()->sortBy('difficulty')->toArray();
        $workSchedule = array_fill_keys(array_keys(self::DEVELOPERS), []);

        foreach ($works as $work) {
            $bestDeveloper = null;
            $minTimeLeft = PHP_INT_MAX;

            foreach (self::DEVELOPERS as $developer => $time) {
                $totalSpendMinutes = $this->sumSpendMinutes($workSchedule, $developer);
                if ($totalSpendMinutes + $time <= self::MAX_WORKABLE_MINUTES_A_WEEK) {
                    $timeLeft = $totalSpendMinutes + $time * $work['difficulty'];

                    if ($timeLeft < $minTimeLeft) {
                        $minTimeLeft = $timeLeft;
                        $bestDeveloper = $developer;
                    }
                }
            }

            $workSchedule[$bestDeveloper][] = [
                'name' => $work['name'],
                'spendMinute' => self::DEVELOPERS[$bestDeveloper] * $work['difficulty']
            ];
        }

        $totalWeeks = 0;
        foreach ($workSchedule as $developer => $schedule) {
            $totalWeeks = max($totalWeeks, ceil($this->sumSpendMinutes($workSchedule, $developer) / self::MAX_WORKABLE_MINUTES_A_WEEK));
        }

        return [
            'workSchedule' => $workSchedule,
            'works' => $works,
            'totalWeeks' => $totalWeeks,
        ];
    }

    /**
     * @param array $schedule
     * @return array
     */
    public function getScheduleNames(array $schedule): array
    {
        return array_map(fn($w) => $w['name'], $schedule);
    }

    /**
     * @param array $workSchedule
     * @param string $developer
     * @return int
     */
    private function sumSpendMinutes(array $workSchedule, string $developer): int
    {
        return array_sum(array_map(fn($w) => $w['spendMinute'], $workSchedule[$developer]));
    }
}
