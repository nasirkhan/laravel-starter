<?php

namespace App\Listeners\Frontend\UserRegistered;

use App\Events\Frontend\UserRegistered;
use App\Notifications\NewRegistration;
use App\Notifications\NewRegistrationFromSocial;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
            try {
                $user->notify(new NewRegistrationFromSocial());
            } catch (\Exception $e) {
                Log::error('UserRegisteredListener: Email Send Failed.');
                Log::error($e);
            }
        } else {
            try {
                $user->notify(new NewRegistration());
            } catch (\Exception $e) {
                Log::error('UserRegisteredListener: Email Send Failed.');
                Log::error($e);
            }
        }
    }
}
