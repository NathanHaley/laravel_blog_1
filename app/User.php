<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;
    use LikableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path'
    ];

    /**
     * @var array
     */
    protected $appends = ['path', 'isLiked', 'likedCount'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email',
        'password',
        'confirmation_token',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean',
    ];

    /**
     *
     */
    public static function bootUser()
    {
        static::deleting(function ($model) {
            $model->likes->each->delete();
        });
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array($this->email, config('blog.administrators'), true);
    }

    /**
     * User has confirmed their email address
     */
    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }

    /**
     * @param $avatar
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return ($avatar) ?  '/storage/'.$avatar : '/images/avatars/default.png';
    }

    /**
     * @param null $user_id
     */
    public function follow($user_id = null)
    {
        //TODO: Add validation
        //TODO: Maybe use relationship is better?

        $this->follows()->create([
            'follow_id' => $user_id
        ]);
        

       static::where('id', $user_id)->increment('follows_count', 1);

    }

    /**
     * @param null $user_id
     */
    public function unfollow($user_id = null)
    {
        //TODO: Add validation
        //TODO: Maybe use relationship is better?

        UserFollow::where(['user_id' => auth()->user()->id, 'follow_id' => $user_id])->delete();


        static::where('id', $user_id)->decrement('follows_count', 1);
    }

    /**
     * @param null $user_id
     * @return bool
     */
    public function isFollowing($user_id = null)
    {
        return $this->follows()
            ->where('follow_id', $user_id)
            ->exists();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function follows()
    {
        return $this->hasMany(UserFollow::class, 'user_id');
    }

    /**
     * @return string
     */
    public function path()
    {
        return route('profile', $this->name);
    }

    /**
     * @return string
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->latest('created_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function liked()
    {
        return $this->hasMany(Like::class);
    }



}
