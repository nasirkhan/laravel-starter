<?php

namespace Modules\Article\Listeners\PostCreated;

use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Modules\Article\Events\PostCreated;

class CreatePostData implements ShouldQueue
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
     * @param object $event
     *
     * @return void
     */
    public function handle(PostCreated $event)
    {
        $post = $event->post;

        Log::debug('Listeners: CreatePostData');
    }
}
