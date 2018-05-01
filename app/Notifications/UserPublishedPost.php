<?php

namespace App\Notifications;

use App\User;
use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserPublishedPost extends Notification
{
    use Queueable;

    protected $user;
    protected $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channel.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->name.' Published: '.$this->post->title,
            'link' => $this->post->path()
        ];
    }
}
