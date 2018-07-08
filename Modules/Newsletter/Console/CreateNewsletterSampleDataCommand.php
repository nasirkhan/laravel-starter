<?php

namespace Modules\Newsletter\Console;

use Artisan;
use Illuminate\Console\Command;

class CreateNewsletterSampleDataCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'newsletter:create-sample-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Sample Data for the Newsletter Module.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('module:seed', [
            'module' => 'Newsletter',
        ]);

        echo "\nCreated Sample Data for _Newsletter_ Module.";
        echo "\n\n";
    }
}
