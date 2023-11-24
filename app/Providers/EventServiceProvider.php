<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        'App\Events\Auth\UserLoginSuccess' => [
            'App\Listeners\Auth\UpdateProfileLoginData',
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
     * Register any events for your application.
     */
    public function boot(): void
    {
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
