<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class NewRegistrationFromSocial extends Notification
{
    use Queueable;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
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

        if ($user->email_verified_at === '') {
            $verificationUrl = $this->verificationUrl($notifiable);

            return (new MailMessage())
                ->subject('Thank you for registration!')
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email Address', $verificationUrl)
                ->line('If you did not create an account, no further action is required.');
        }

        return (new MailMessage())
            ->subject('Thank you for registration!')
            ->line('Thank you for registration at '.app_name().'.')
            ->action('Vist Application', url('/'))
            ->line('We are really happy that you started to use '.app_name().'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $user = $notifiable;

        $text = 'Registration Completed! | New registration completed for <strong>'.$user->name.'</strong>';

        $url_backend = route('backend.users.profile', $user->id);
        $url_frontend = route('frontend.users.profile', $user->id);

        return [
            'title' => 'Registration Completed!',
            'module' => 'User',
            'type' => 'created', // created, published, viewed,
            'icon' => 'fas fa-user',
            'text' => $text,
            'url_backend' => $url_backend,
            'url_frontend' => $url_frontend,
        ];
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
