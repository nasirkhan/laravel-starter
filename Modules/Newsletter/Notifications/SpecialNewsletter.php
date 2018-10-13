<?php

namespace Modules\Newsletter\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Article\Entities\Newsletter;
use App\Models\User;

class SpecialNewsletter extends Notification implements ShouldQueue
{
    use Queueable;

    public $newsletter;
    public $user;

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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $newsletter = $this->newsletter;
        $newsletter_name = $newsletter->name;

        $user = $this->user;
        $user_name = $user->name;

        return (new MailMessage)
                    ->subject("Newsletter: $newsletter_name")
                    ->greeting("Hello $user_name!")
                    ->line('Thank you for your application. "'.$newsletter_name.'" is our new newsletter.')
                    ->action('Action', '#');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
