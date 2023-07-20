<?php

namespace App\Console\Commands;

use App\Http\Controllers\WorkController;
use Illuminate\Console\Command;

class SaveWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:work';

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
        (new WorkController())->store();
        return Command::SUCCESS;
    }
}
