<?php

namespace App\Events\Backend;

use App\Models\Userprofile;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserProfileUpdated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $user_profile;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Userprofile $user_profile)
    {
        $this->user_profile = $user_profile;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
