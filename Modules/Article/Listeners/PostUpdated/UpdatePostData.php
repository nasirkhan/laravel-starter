<?php

namespace Modules\Article\Listeners\PostUpdated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Article\Events\PostUpdated;
use Log;

class UpdatePostData implements ShouldQueue
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
    public function handle(PostUpdated $event)
    {
        $post = $event->post;

        Log::debug('Listeners: UpdatePostData');
    }
}
