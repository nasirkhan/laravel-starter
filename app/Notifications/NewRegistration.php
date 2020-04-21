<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegistration extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $notifiable;

        return (new MailMessage)
                    ->subject("Thank you for registration!")
                    ->line("Thank you for registration at ".app_name().".")
                    ->action("Vist Application", url('/'))
                    ->line("We are really happy that you started to use ".app_name()."!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $user = $notifiable;

        $text = 'Registration Completed! | New registration completed for <strong>'.$user->name.'</strong>';

        $url_backend = route('backend.users.profile', $user->id);
        $url_frontend = route('frontend.users.profile', $user->id);

        return [
            'title'         => 'Registration Completed!',
            'module'        => 'User',
            'type'          => 'created', // created, published, viewed,
            'icon'          => 'fas fa-user',
            'text'          => $text,
            'url_backend'   => $url_backend,
            'url_frontend'  => $url_frontend,
        ];
    }
}
