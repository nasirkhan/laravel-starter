<?php

namespace Modules\Post\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Post\Events\PostViewed;
use Modules\Post\Listeners\PostViewed\IncrementPostHits;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        /**
         * Backend.
         */

        /**
         * Frontend.
         */
        PostViewed::class => [
            IncrementPostHits::class,
        ],
    ];
}
