<?php

namespace App\Listeners;

use App\Events\UserPublishedNewPost;

class NotifyFollowers
{
    public function handle(UserPublishedNewPost $event)
    {
        $event->post->user->followers
            //->where('follow_id', '!=', $event->post->user_id)
            ->each
            ->notify($event->post);
    }
}
