<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\Backend\UserCreated' => [
            'App\Listeners\Backend\UserCreated\UserCreatedProfileCreate',
            'App\Listeners\Backend\UserCreated\UserCreatedNotifySuperUser',
        ],
        'App\Events\Backend\UserUpdated' => [
            'App\Listeners\Backend\UserUpdated\UserUpdatedNotifyUser',
            'App\Listeners\Backend\UserUpdated\UserUpdatedProfileUpdate',
        ],
        'App\Events\Backend\UserProfileUpdated' => [
            'App\Listeners\Backend\UserProfileUpdated\UserProfileUpdatedNotifyUser',
            'App\Listeners\Backend\UserProfileUpdated\UserProfileUpdatedUserUpdate',
        ],
        'App\Events\Frontend\UserRegistered' => [
            'App\Listeners\Frontend\UserRegistered\UserRegisteredListener',
            'App\Listeners\Frontend\UserRegistered\UserRegisteredProfileCreate',
        ],
        'App\Events\Frontend\UserUpdated' => [
            'App\Listeners\Frontend\UserUpdated\UserUpdatedNotifyUser',
            'App\Listeners\Frontend\UserUpdated\UserUpdatedProfileUpdate',
        ],
        'App\Events\Frontend\UserProfileUpdated' => [
            'App\Listeners\Frontend\UserProfileUpdated\UserProfileUpdatedNotifyUser',
            'App\Listeners\Frontend\UserProfileUpdated\UserProfileUpdatedUserUpdate',
        ],
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UserEventSubscriber',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
