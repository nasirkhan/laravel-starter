<?php

namespace App\Listeners\Backend\User;

use App\Events\Backend\User\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedNotifyUser implements ShouldQueue
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
     * @param UserCreated $event
     *
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;
        //
    }
}
