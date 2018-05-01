<?php

namespace App;

use App\Notifications\UserPublishedPost;
use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function follow()
    {
        return $this->belongsTo(User::class, 'follow_id');
    }

    public function notify(Post $post)
    {
        $this->user->notify(new UserPublishedPost($this->user, $post));
    }
}
