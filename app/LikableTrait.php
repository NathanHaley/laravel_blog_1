<?php

namespace App;

trait LikableTrait
{
    /*
     * NOTE: Implementing class needs method getPathAttribute.
     * Need to append isLiked and likesCount
     */

    public static function bootFavoritable()
    {
        if (auth()->guest()) {
            return;
        }

        static::deleting(function ($model) {
            $model->likes->each->delete();
        });
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'liked');
    }

    public function like()
    {
        if(! auth()->check()) return response('You must login.', 403);

        $attributes = [
            'user_id' => auth()->id(),
            'liked_id' => $this->id,
        ];

        if (!$this->likes()->where($attributes)->exists()) {
            return $this->likes()->create($attributes);
        }
    }

    public function unlike()
    {
        if(! auth()->check()) return response('You must login.', 403);

        $attributes = ['user_id' => auth()->id()];

        $this->likes()->where($attributes)->get()->each->delete();
    }

    public function isLiked()
    {
        return !!$this->likes->where('user_id', auth()->id())->count();
    }

    public function getIsLikedAttribute()
    {
        return $this->isLiked();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

}