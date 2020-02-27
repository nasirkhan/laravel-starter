<?php

namespace Modules\Newsletter\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Article\Entities\Newsletter;

/**
 * An Event to handle the Newsletter Dispatch.
 */
class DispatchNewsletter
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
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
