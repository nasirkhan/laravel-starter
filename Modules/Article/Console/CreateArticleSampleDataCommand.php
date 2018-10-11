<?php

namespace Modules\Article\Console;

use Artisan;
use Illuminate\Console\Command;

class CreateArticleSampleDataCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'article:create-sample-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Sample Data for the Article Module.';

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
            'module' => 'Article',
        ]);

        echo "\nCreated Sample Data for _Article_ Module.";
        echo "\n\n";
    }
}
