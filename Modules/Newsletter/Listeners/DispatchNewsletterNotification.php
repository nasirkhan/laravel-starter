<?php

namespace Modules\Newsletter\Listeners;

use Modules\Newsletter\Events\DispatchNewsletter;
use Modules\Newsletter\Notifications\SpecialNewsletter;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

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
     * @param  DispatchNewsletter  $event
     * @return void
     */
    public function handle(DispatchNewsletter $event)
    {
        $newsletter = $event->newsletter;
        $user = $event->user;

        $user->notify(new SpecialNewsletter($newsletter, $user));
        // Notification::send($user, new SpecialNewsletter($newsletter));

        echo "\n\nDispatchNewsletterListener\n\n";
    }
}
