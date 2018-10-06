<?php

namespace App\Listeners\Frontend\User;

use App\Events\Frontend\User\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdatedProfileUpdate implements ShouldQueue
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
     * @param UserUpdated $event
     *
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        $user = $event->user;
        //
    }
}
