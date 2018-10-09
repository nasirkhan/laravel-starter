<?php

namespace App\Listeners\Frontend\User;

use App\Events\Frontend\User\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredProfileCreate implements ShouldQueue
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
        //
    }
}
