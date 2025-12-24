<?php

namespace Modules\Post\Listeners\PostViewed;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Post\Events\PostViewed;

class IncrementPostHits implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(PostViewed $event): void
    {
        $event->post->incrementHits();
        logger()->info('Post hits incremented for Post ID: ' . $event->post->id);
    }
}
