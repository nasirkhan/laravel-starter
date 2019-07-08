<?php

namespace Modules\Article\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Modules\Article\Entities\Comment;

class NewCommentAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $comment = $this->comment;
        $user = $notifiable;

        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $comment = $this->comment;
        $user = $notifiable;

        return (new SlackMessage)
                ->success()
                ->from('BlueCube', ':incoming_envelope:')
                ->content('New Comment: '.$comment->name.' | From:'.$comment->user_name)
                ->attachment(function ($attachment) use ($comment) {
                    $attachment->title('Comment '.$comment->id, route('backend.comments.show',$comment->id))
                    ->fields([
                        'Post' => $comment->post_name,
                        'User' => $comment->user_name,
                        'Comment' => $comment->name,
                        'Status' => $comment->status_label_text,
                    ]);
                });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $comment = $this->comment;
        $user = $notifiable;

        return [
            'id' => $comment->id,
            'name' => $comment->name,
            'comment' => $comment->comment,
            'post_id' => $comment->post_id,
            'post_name' => $comment->post_name,
            'user_id' => $comment->user_id,
            'user_name' => $comment->user_name,
            'status' => $comment->status,
        ];
    }
}
