<?php

namespace Modules\Newsletter\Console;

use Artisan;
use Illuminate\Console\Command;

class CreateNewsletterPermissionsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'newsletter:create-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Permissions for the Newsletter Module.';

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
        Artisan::call('auth:permission', [
            'name' => 'newsletters',
        ]);

        echo "\nCreated Permissions for the Module.";
        echo "\nAlso the permissions have been added to the Admin User.";
        echo "\n\n";
    }
}
