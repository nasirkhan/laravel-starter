<?php

namespace App\Listeners\Frontend\UserRegistered;

use App\Events\Frontend\UserRegistered;
use App\Notifications\NewRegistration;
use App\Notifications\NewRegistrationFromSocial;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class UserRegisteredListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserRegistered $event
     *
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        // Create Log
        Log::info('New User Registered as '.$user->name);

        // Send Email To Registered User
        if ($user->password == '') {
            // Register via social do not have passwords
            $user->notify(new NewRegistrationFromSocial());
        } else {
            $user->notify(new NewRegistration());
        }
    }
}
