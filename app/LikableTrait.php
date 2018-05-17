<?php

namespace App;

use App\Exceptions\BlogApiException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as Http;

trait LikableTrait
{
    /*
     * NOTE: Implementing class needs method getPathAttribute.
     * Need to append isLiked and likesCount
     * User class needs likes relationship
     */

    public static function bootLikableTrait()
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


    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws BlogApiException
     */
    public function like()
    {
        try {
            DB::transaction(function () {
                $attributes = [
                    'user_id' => auth()->id(),
                    'liked_id' => $this->id,
                ];

                $this->increment('likes_count');

                return $this->likes()->create($attributes);
            });
        } catch (\Throwable $e) {

            throw new BlogApiException('Attempt to like user failed.', Http::HTTP_INTERNAL_SERVER_ERROR, $e);

        }
    }

    /**
     * @throws BlogApiException
     */
    public function unlike()
    {

        try {
            DB::transaction(function () {
                $attributes = ['user_id' => auth()->id()];

                $this->likes()->where($attributes)->get()->each->delete();

                $this->decrement('likes_count');
            });
        } catch (\Throwable $e) {;
            throw new BlogApiException('Attempt to like user failed.', Http::HTTP_INTERNAL_SERVER_ERROR, $e);

        }

    }

    public function isLiked()
    {
        return !!$this->likes->where('user_id', auth()->id())->count();
    }

    public function getIsLikedAttribute()
    {
        return $this->isLiked();
    }

    public function getLikedCountAttribute()
    {
        return $this->likes->count();
    }

}