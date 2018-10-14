<?php

namespace Modules\Newsletter\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Newsletter\Events\DispatchNewsletter;
use Modules\Newsletter\Listeners\DispatchNewsletterListener;
use Modules\Newsletter\Listeners\DispatchNewsletterNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        DispatchNewsletter::class => [
            DispatchNewsletterListener::class,
            DispatchNewsletterNotification::class,
        ],
    ];
}
