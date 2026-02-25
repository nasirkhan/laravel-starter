<?php

return  [
    'barryvdh/laravel-debugbar' => [
        'aliases' => [
            'Debugbar' => 'Barryvdh\\Debugbar\\Facades\\Debugbar',
        ],
        'providers' => [
            0 => 'Barryvdh\\Debugbar\\ServiceProvider',
        ],
    ],
    'intervention/image-laravel' => [
        'aliases' => [
            'Image' => 'Intervention\\Image\\Laravel\\Facades\\Image',
        ],
        'providers' => [
            0 => 'Intervention\\Image\\Laravel\\ServiceProvider',
        ],
    ],
    'laracasts/flash' => [
        'aliases' => [
            'Flash' => 'Laracasts\\Flash\\Flash',
        ],
        'providers' => [
            0 => 'Laracasts\\Flash\\FlashServiceProvider',
        ],
    ],
    'laravel/boost' => [
        'providers' => [
            0 => 'Laravel\\Boost\\BoostServiceProvider',
        ],
    ],
    'laravel/breeze' => [
        'providers' => [
            0 => 'Laravel\\Breeze\\BreezeServiceProvider',
        ],
    ],
    'laravel/mcp' => [
        'aliases' => [
            'Mcp' => 'Laravel\\Mcp\\Server\\Facades\\Mcp',
        ],
        'providers' => [
            0 => 'Laravel\\Mcp\\Server\\McpServiceProvider',
        ],
    ],
    'laravel/pail' => [
        'providers' => [
            0 => 'Laravel\\Pail\\PailServiceProvider',
        ],
    ],
    'laravel/roster' => [
        'providers' => [
            0 => 'Laravel\\Roster\\RosterServiceProvider',
        ],
    ],
    'laravel/sail' => [
        'providers' => [
            0 => 'Laravel\\Sail\\SailServiceProvider',
        ],
    ],
    'laravel/socialite' => [
        'aliases' => [
            'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
        ],
        'providers' => [
            0 => 'Laravel\\Socialite\\SocialiteServiceProvider',
        ],
    ],
    'laravel/tinker' => [
        'providers' => [
            0 => 'Laravel\\Tinker\\TinkerServiceProvider',
        ],
    ],
    'livewire/livewire' => [
        'aliases' => [
            'Livewire' => 'Livewire\\Livewire',
        ],
        'providers' => [
            0 => 'Livewire\\LivewireServiceProvider',
        ],
    ],
    'nasirkhan/laravel-cube' => [
        'providers' => [
            0 => 'Nasirkhan\\LaravelCube\\CubeServiceProvider',
        ],
    ],
    'nasirkhan/module-manager' => [
        'aliases' => [
            'ModuleManager' => 'Nasirkhan\\ModuleManager\\ModuleManagerFacade',
        ],
        'providers' => [
            0 => 'Nasirkhan\\ModuleManager\\ModuleManagerServiceProvider',
        ],
    ],
    'nesbot/carbon' => [
        'providers' => [
            0 => 'Carbon\\Laravel\\ServiceProvider',
        ],
    ],
    'nunomaduro/collision' => [
        'providers' => [
            0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
        ],
    ],
    'nunomaduro/termwind' => [
        'providers' => [
            0 => 'Termwind\\Laravel\\TermwindServiceProvider',
        ],
    ],
    'opcodesio/log-viewer' => [
        'aliases' => [
            'LogViewer' => 'Opcodes\\LogViewer\\Facades\\LogViewer',
        ],
        'providers' => [
            0 => 'Opcodes\\LogViewer\\LogViewerServiceProvider',
        ],
    ],
    'spatie/laravel-activitylog' => [
        'providers' => [
            0 => 'Spatie\\Activitylog\\ActivitylogServiceProvider',
        ],
    ],
    'spatie/laravel-backup' => [
        'providers' => [
            0 => 'Spatie\\Backup\\BackupServiceProvider',
        ],
    ],
    'spatie/laravel-html' => [
        'aliases' => [
            'Html' => 'Spatie\\Html\\Facades\\Html',
        ],
        'providers' => [
            0 => 'Spatie\\Html\\HtmlServiceProvider',
        ],
    ],
    'spatie/laravel-medialibrary' => [
        'providers' => [
            0 => 'Spatie\\MediaLibrary\\MediaLibraryServiceProvider',
        ],
    ],
    'spatie/laravel-permission' => [
        'providers' => [
            0 => 'Spatie\\Permission\\PermissionServiceProvider',
        ],
    ],
    'spatie/laravel-signal-aware-command' => [
        'aliases' => [
            'Signal' => 'Spatie\\SignalAwareCommand\\Facades\\Signal',
        ],
        'providers' => [
            0 => 'Spatie\\SignalAwareCommand\\SignalAwareCommandServiceProvider',
        ],
    ],
    'unisharp/laravel-filemanager' => [
        'aliases' => [
        ],
        'providers' => [
            0 => 'UniSharp\\LaravelFilemanager\\LaravelFilemanagerServiceProvider',
        ],
    ],
    'yajra/laravel-datatables-oracle' => [
        'aliases' => [
            'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
        ],
        'providers' => [
            0 => 'Yajra\\DataTables\\DataTablesServiceProvider',
        ],
    ],
];
