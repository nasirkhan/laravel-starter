<?php

namespace Modules\Menu\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        /**
         * Backend.
         */
        'Modules\Menu\Events\Backend\NewCreated' => [
            'Modules\Menu\Listeners\Backend\NewCreated\UpdateAllOnNewCreated',
        ],

    /**
     * Frontend.
     */
    ];
}
