<?php

namespace App\Listeners\Frontend\UserRegistered;

use App\Events\Frontend\UserRegistered;
use App\Notifications\NewRegistrationNotification;
use App\Notifications\NewRegistrationNotificationForSocial;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class EmailNotificationOnUserRegistered implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;
        $request = $event->request;

        // Create Log
        Log::info('New User Registered as '.$user->name);

        // Send Email To Registered User
        if ($user->password === '') {
            // Register via social do not have passwords
            try {
                $user->notify(new NewRegistrationNotificationForSocial);
            } catch (\Exception $e) {
                Log::error('UserRegisteredListener: Email Send Failed.');
                Log::error($e);
            }
        } else {
            try {
                $user->notify(new NewRegistrationNotification);
            } catch (\Exception $e) {
                Log::error('UserRegisteredListener: Email Send Failed.');
                Log::error($e);
            }
        }
    }
}
