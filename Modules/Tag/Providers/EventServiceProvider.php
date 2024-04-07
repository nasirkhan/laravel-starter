<?php

namespace Modules\Tag\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        /**
         * Backend.
         */
        'Modules\Tag\Events\Backend\NewCreated' => [
            'Modules\Tag\Listeners\Backend\NewCreated\UpdateAllOnNewCreated',
        ],

    /**
     * Frontend.
     */
    ];
}
