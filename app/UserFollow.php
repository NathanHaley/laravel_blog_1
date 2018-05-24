<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\UserPublishedPost;

/**
 * Class UserFollow
 * @package App
 */
class UserFollow extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'follow_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function follow()
    {
        return $this->belongsTo(User::class, 'follow_id');
    }

    /**
     * @param Post $post
     */
    public function notify(Post $post)
    {
        $this->user->notify(new UserPublishedPost(auth()->user(), $post));
    }
}
