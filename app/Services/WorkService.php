<?php

namespace App\Services;

use App\Adapters\Provider1Adapter;
use App\Adapters\Provider2Adapter;
use App\Interfaces\ApiInterface;
use App\Models\Work;
use Illuminate\Support\Facades\Http;

class WorkService
{
    private const PROVIDERS = [
        [
            'type' => Provider1Adapter::class,
            'url' => 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa'
        ],
        [
            'type' => Provider2Adapter::class,
            'url' => 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7'
        ],
    ];

    /**
     * @return ApiInterface[]
     */
    private function fetchMockData(): array
    {
        $works = [];
        foreach (self::PROVIDERS as $api) {
            $mockData = Http::get($api['url'])->json();
            foreach ($mockData as $m) {
                $works[] = new $api['type']($m);
            }
        }
        return $works;
    }

    /**
     * @param bool $reset
     * @return void
     */
    public function saveData(bool $reset): void
    {
        $works = $this->fetchMockData();

        if ($reset) {
            Work::query()->delete();
        }

        foreach ($works as $w) {
            $workModel = new Work();
            $workModel->name = $w->getName();
            $workModel->time = $w->getTime();
            $workModel->difficulty = $w->getDifficulty();
            $workModel->save();
        }
    }
}
