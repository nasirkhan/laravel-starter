<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $this->callSilently('migrate:fresh', ['--no-interaction' => true]);

        $this->info('Reset Database seeds');
        $this->callSilently('db:seed', ['--no-interaction' => true]);

        $this->info('Insert Demo Data again');
        $this->callSilently('laravel-starter:insert-demo-data', ['--no-interaction' => true]);

        $this->callSilently('cache:clear', ['--no-interaction' => true]);
    }
}
