<?php

namespace Modules\Newsletter\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Newsletter\Events\DispatchNewsletter;

class DispatchNewsletterListener implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param DispatchNewsletter $event
     *
     * @return void
     */
    public function handle(DispatchNewsletter $event)
    {
        $newsletter = $event->newsletter;
        $user = $event->user;

        echo "\n\nDispatchNewsletterListener\n\n";
    }
}
