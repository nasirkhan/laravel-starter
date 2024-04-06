<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Config
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => 'Modules',

    'stubs' => [
        // 'path' => base_path('stubs/laravel-starter-stubs'),

        'path' => base_path('vendor/nasirkhan/module-manager/src/stubs'),
    ],

    'module' => [
        'files' => [
            'composer' => ['composer.stub', 'composer.json'],
            'json' => ['module.stub', 'module.json'],
            'config' => ['Config/config.stub', 'Config/config.php'],
            'database' => ['database/migrations/stubMigration.stub', 'database/migrations/stubMigration.php', 'rename'],
            'factories' => ['database/factories/stubFactory.stub', 'database/factories/stubFactory.php', 'rename'],
            'seeders' => ['database/seeders/stubSeeders.stub', 'database/seeders/stubSeeders.php', 'rename'],
            'command' => ['Console/Commands/StubCommand.stub', 'Console/Commands/StubCommand.php', 'rename'],
            'lang' => ['lang/en/text.stub', 'lang/en/text.php'],
            'models' => ['Models/stubModel.stub', 'Models/stubModel.php'],
            'providersRoute' => ['Providers/RouteServiceProvider.stub', 'Providers/RouteServiceProvider.php'],
            'providersEvent' => ['Providers/EventServiceProvider.stub', 'Providers/EventServiceProvider.php'],
            'providers' => ['Providers/stubServiceProvider.stub', 'Providers/stubServiceProvider.php'],
            'route_web' => ['routes/web.stub', 'routes/web.php'],
            'route_api' => ['routes/api.stub', 'routes/api.php'],
            'controller_backend' => ['Http/Controllers/Backend/stubBackendController.stub', 'Http/Controllers/Backend/stubBackendController.php'],
            'controller_frontend' => ['Http/Controllers/Frontend/stubFrontendController.stub', 'Http/Controllers/Frontend/stubFrontendController.php'],
            'views_backend_index' => ['Resources/views/backend/stubViews/index.blade.stub', 'Resources/views/backend/stubViews/index.blade.php'],
            'views_backend_index_datatable' => ['Resources/views/backend/stubViews/index_datatable.blade.stub', 'Resources/views/backend/stubViews/index_datatable.blade.php'],
            'views_backend_create' => ['Resources/views/backend/stubViews/create.blade.stub', 'Resources/views/backend/stubViews/create.blade.php'],
            'views_backend_form' => ['Resources/views/backend/stubViews/form.blade.stub', 'Resources/views/backend/stubViews/form.blade.php'],
            'views_backend_show' => ['Resources/views/backend/stubViews/show.blade.stub', 'Resources/views/backend/stubViews/show.blade.php'],
            'views_backend_edit' => ['Resources/views/backend/stubViews/edit.blade.stub', 'Resources/views/backend/stubViews/edit.blade.php'],
            'views_backend_trash' => ['Resources/views/backend/stubViews/trash.blade.stub', 'Resources/views/backend/stubViews/trash.blade.php'],
            'views_frontend_index' => ['Resources/views/frontend/stubViews/index.blade.stub', 'Resources/views/frontend/stubViews/index.blade.php'],
            'views_frontend_show' => ['Resources/views/frontend/stubViews/show.blade.stub', 'Resources/views/frontend/stubViews/show.blade.php'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Composer
    |--------------------------------------------------------------------------
    |
    | Config for the composer.json file
    |
    */

    'composer' => [
        'vendor' => 'nasirkhan',
        'author' => [
            'name' => 'Nasir Khan',
            'email' => 'nasir8891@gmail.com',
        ],
    ],

    'files' => [
        'module-list' => base_path('modules_statuses.json'),
    ],
];
