<?php

namespace App\Console\Commands;

use App\Services\WorkService;
use Illuminate\Console\Command;

class SaveWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:work {--reset}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save works with mock API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reset = !!$this->option('reset');
        (new WorkService())->saveData($reset);
        return Command::SUCCESS;
    }
}
