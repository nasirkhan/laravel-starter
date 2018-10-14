<?php

namespace Modules\Newsletter\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Newsletter\Events\DispatchNewsletter;
use Modules\Newsletter\Notifications\SpecialNewsletter;

class DispatchNewsletterNotification implements ShouldQueue
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

        $user->notify(new SpecialNewsletter($newsletter, $user));

        echo "\n\nDispatchNewsletterListener\n\n";
    }
}
