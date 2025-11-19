<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Change default string length.
         *
         * MariaDB 10.5 allows index keys to be 3072 chars.
         * MySQL 8.0 appears to be allowing only 1000 chars.
         */
        Schema::defaultStringLength(125);

        /**
         * Register Event Listeners.
         */
        $this->registerEventListeners();

        /**
         * Register Model Observers.
         * This is where you can register observers for your models.
         */
        // User model observer
        User::observe(UserObserver::class);

        /**
         * Implicitly grant "Super Admin" role all permissions
         * This works in the app by using gate-related functions like auth()->user->can() and @can().
         */
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });
    }

    public function registerEventListeners()
    {
        /**
         * Auth Event Listeners.
         */
        // Event::listen(
        //     'App\Events\Auth\UserLoginSuccess',
        //     'App\Listeners\Auth\UpdateLoginData',
        //     'App\Listeners\Auth\SendPodcastNotification'
        // );

        /**
         * Frontend Event Listeners.
         */
        // Event::listen('App\Events\Frontend\UserRegistered',
        //     'App\Listeners\Frontend\UserRegistered\EmailNotificationOnUserRegistered'
        // );

        /**
         * Backend Event Listeners.
         */
        // Event::listen(
        //     'App\Events\Backend\UserCreated',
        //     'App\Listeners\Backend\UserCreated\UserCreatedProfileCreate',
        //     'App\Listeners\Backend\UserCreated\UserCreatedNotifySuperUser'
        // );

        // Event::listen(
        //     'App\Events\Backend\UserUpdated',
        //     'App\Listeners\Backend\UserUpdated\UserUpdatedNotifyUser'
        // );
    }
}
