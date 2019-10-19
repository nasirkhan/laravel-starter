<?php

namespace Modules\Article\Listeners\PostViewed;

use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Modules\Article\Events\PostViewed;

class IncrementHitCount implements ShouldQueue
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
    public function handle(PostViewed $event)
    {
        $post = $event->post;

        $post->increment('hits');

        $post->view_counter += 1;

        Log::debug('Listeners: IncrementHitCount');
    }
}
