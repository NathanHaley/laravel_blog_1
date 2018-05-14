<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use LikableTrait;

    protected $appends = ['path', 'isLiked', 'likesCount'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
        'follows_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];



    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function isAdmin()
    {
        return in_array($this->email, config('blog.administrators'), true);
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }

    public function getAvatarPathAttribute($avatar)
    {
        return ($avatar) ?  '/storage/'.$avatar : '/images/avatars/default.png';
    }

    public function follow($user_id = null)
    {
        //TODO: Add validation
        //TODO: Maybe use relationship is better?

        $this->follows()->create([
            'follow_id' => $user_id
        ]);
        

       static::where('id', $user_id)->increment('follows_count', 1);

    }

    public function unfollow($user_id = null)
    {
        //TODO: Add validation
        //TODO: Maybe use relationship is better?

        UserFollow::where(['user_id' => auth()->user()->id, 'follow_id' => $user_id])->delete();


        static::where('id', $user_id)->decrement('follows_count', 1);
    }

    public function isFollowing($user_id = null)
    {
        return $this->follows()
            ->where('follow_id', $user_id)
            ->exists();
    }

    public function follows()
    {
        return $this->hasMany(UserFollow::class, 'user_id');
    }

    public function path()
    {
        return route('profile', $this->name);
    }

    public function getPathAttribute()
    {
        return $this->path();
    }

//    public function getCreatedAtAttribute($created_at)
//    {
//        $dateTime = Carbon::create($created_at);
//
//        return $dateTime;
//    }

    public function posts()
    {
        return $this->hasMany(Post::class)->latest('created_at');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
