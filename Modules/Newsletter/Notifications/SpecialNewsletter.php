<?php

namespace Modules\Newsletter\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Article\Entities\Newsletter;

class SpecialNewsletter extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Newsletter $newsletter, User $user)
    {
        $this->newsletter = $newsletter;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $newsletter = $notifiable->newsletter;
        $newsletter_name = $newsletter->name;
        $user = $notifiable->user;
        $user_name = $user_name->name;

        return (new MailMessage())
                    ->subject("Newsletter: $newsletter_name")
                    ->greeting("Hello $user_name!")
                    ->line('Thank you for your application. "'.$newsletter_name.'" is our new newsletter.')
                    ->action('Action', '#');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
