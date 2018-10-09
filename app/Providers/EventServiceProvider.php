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
        'App\Events\Backend\User\UserCreated' => [
            'App\Listeners\Backend\User\UserCreatedNotifyUser',
            'App\Listeners\Backend\User\UserCreatedProfileCreate',
        ],
        'App\Events\Backend\User\UserUpdated' => [
            'App\Listeners\Backend\User\UserUpdatedNotifyUser',
            'App\Listeners\Backend\User\UserUpdatedProfileUpdate',
        ],
        'App\Events\Backend\User\UserProfileUpdated' => [
            'App\Listeners\Backend\User\UserProfileUpdatedNotifyUser',
            'App\Listeners\Backend\User\UserProfileUpdatedUserUpdate',
        ],
        'App\Events\Frontend\User\UserRegistered' => [
            'App\Listeners\Frontend\User\UserRegisteredListener',
            'App\Listeners\Frontend\User\UserRegisteredProfileCreate',
        ],
        'App\Events\Frontend\User\UserUpdated' => [
            'App\Listeners\Frontend\User\UserUpdatedNotifyUser',
            'App\Listeners\Frontend\User\UserUpdatedProfileUpdate',
        ],
        'App\Events\Frontend\User\UserProfileUpdated' => [
            'App\Listeners\Frontend\User\UserProfileUpdatedNotifyUser',
            'App\Listeners\Frontend\User\UserProfileUpdatedUserUpdate',
        ],
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
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
