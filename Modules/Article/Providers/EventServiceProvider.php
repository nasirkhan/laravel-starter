<?php

namespace Modules\Article\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\Article\Events\PostCreated' => [
            'Modules\Article\Listeners\PostCreated\CreatePostData',
        ],
        'Modules\Article\Events\PostUpdated' => [
            'Modules\Article\Listeners\PostUpdated\UpdatePostData',
        ],
        'Modules\Article\Events\PostViewed' => [
            'Modules\Article\Listeners\PostViewed\IncrementHitCount',
        ],
    ];
}
