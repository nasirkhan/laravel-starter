<?php

namespace App\Listeners\Backend\UserCreated;

use App\Events\Backend\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedNotifySuperUser implements ShouldQueue
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
    public function handle(UserCreated $event)
    {
        $user = $event->user;
    }
}
