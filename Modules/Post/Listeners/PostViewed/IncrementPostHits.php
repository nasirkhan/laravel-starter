<?php

namespace Modules\Post\Listeners\PostViewed;

use Modules\Post\Events\PostViewed;

class IncrementPostHits
{
    /**
     * Handle the event.
     */
    public function handle(PostViewed $event): void
    {
        defer(function () use ($event) {
            $event->post->incrementHits();
        });
    }
}
