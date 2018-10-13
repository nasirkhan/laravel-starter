<?php

namespace Modules\Newsletter\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Article\Entities\Newsletter;
use App\Models\User;

/**
 * An Event to handle the Newsletter Dispatch
 */
class DispatchNewsletter
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $newsletter;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Newsletter $newsletter, User $user)
    {
        $this->newsletter = $newsletter;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
