<?php

return [
    'name' => env('APP_NAME', 'Admin'),

    'logo' => null,

    'theme' => 'system',

    'nav' => [
        [
            'label'    => 'Dashboard',
            'route'    => 'backend.dashboard',
            'icon'     => 'home',
            'children' => [],
        ],
        [
            'label'    => 'Notifications',
            'route'    => 'backend.notifications.index',
            'icon'     => 'bell',
            'children' => [],
        ],
        [
            'label'    => 'Users',
            'route'    => 'backend.users.index',
            'icon'     => 'users',
            'children' => [],
        ],
        [
            'label'    => 'Roles',
            'route'    => 'backend.roles.index',
            'icon'     => 'shield',
            'children' => [],
        ],
    ],
];
