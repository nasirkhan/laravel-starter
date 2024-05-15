<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the demo site.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $demo_mode = config('app.demo_mode');

        if ($demo_mode == true) {
            $this->warn("\n\n Demo Mode is ON \n");

            $this->resetDemoData();
        } else {
            $this->warn("\n\n Demo Mode is OFF \n");
        }
    }

    public function resetDemoData()
    {
        $this->info('Reset Database and migrate fresh');
        Artisan::call('migrate:fresh');

        $this->info('Reset Database seeds');
        Artisan::call('db:seed');

        $this->info('Insert Demo Data again');
        Artisan::call('laravel-starter:insert-demo-data');
    }
}
