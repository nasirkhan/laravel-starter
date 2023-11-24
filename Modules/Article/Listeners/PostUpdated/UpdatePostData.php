<?php

namespace Modules\Article\Listeners\PostUpdated;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Article\Events\PostUpdated;

class UpdatePostData implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostUpdated $event)
    {
        $post = $event->post;

        Log::debug('Listeners: UpdatePostData');
    }
}
