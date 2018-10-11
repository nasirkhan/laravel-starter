<?php

namespace Modules\Article\Console;

use Artisan;
use Illuminate\Console\Command;

class CreateArticlePermissionsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'article:create-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Permissions for the Article Module and all submodules.';

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
            'name' => 'posts',
        ]);
        echo "\n _Posts_ Permissions Created.";

        Artisan::call('auth:permission', [
            'name' => 'categories',
        ]);
        echo "\n _Categories_ Permissions Created.";

        Artisan::call('auth:permission', [
            'name' => 'tags',
        ]);
        echo "\n _Tags_ Permissions Created.";

        echo "\n\n All _Article Module_ Permissions Created.";
        echo "\nAlso the permissions have been added to the Admin User.";
        echo "\n\n";
    }
}
