<?php

namespace Modules\Article\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Article\Entities\Post;

class PostCreated
{
    use SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
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
