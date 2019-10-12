<?php

namespace Modules\Article\Listeners\PostCreated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Article\Events\PostCreated;
use Log;

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
     * @param  object  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        $post = $event->post;

        Log::debug('Listeners: CreatePostData');
    }
}
