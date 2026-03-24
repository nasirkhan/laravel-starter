<?php

namespace App\Listeners\Frontend\UserRegistered;

use App\Events\Frontend\UserRegistered;
use App\Notifications\NewRegistrationNotification;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $event->user->notify(new NewRegistrationNotification);
    }
}
