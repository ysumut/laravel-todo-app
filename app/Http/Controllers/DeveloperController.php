<?php

namespace App\Http\Controllers;

use App\Services\DeveloperService;
use App\Services\WorkService;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function workPlan(Request $request): string
    {
        $workService = new WorkService();
        $developerService = (new DeveloperService($workService));
        $workPlan = $developerService->calculateWorkPlan();

        $totalWeeks = $workPlan['totalWeeks'];
        $message = "Toplam Hafta Sayısı: $totalWeeks hafta<br/><br/>";
        foreach ($workPlan['workSchedule'] as $developer => $schedule) {
            $message .= "$developer: " . implode(', ', $developerService->getScheduleNames($schedule)) . "<br/><br/>";
        }
        return $message;
    }
}
