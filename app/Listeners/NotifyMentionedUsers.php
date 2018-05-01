<?php

namespace App\Listeners;

use App\Events\UserPublishedNewPost;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  UserPublishedNewPost $event
     * @return void
     */
    public function handle(UserPublishedNewPost $event)
    {
        $users = User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user
                    ->notify(new YouWereMentioned($event->reply));
            });
    }
}
