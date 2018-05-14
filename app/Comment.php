<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    use LikableTrait;

    protected $guarded = [];

    protected $with = ['user'];

    protected $appends = ['path', 'isLiked', 'likesCount'];

    protected $dates = [
        'created_at',
        'updated_at',
        //    'deleted_at'
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    static function validations($id = null)
    {
        return [
            'body' => 'required|max:500',
        ];
    }

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

    /**
     * Set the body attribute.
     *
     * @param string $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
        );
    }

    public function path()
    {
        return $this->post->path()."/comment/{$this->id}";
    }

    public function getPathAttribute()
    {
        return $this->post->path()."/comment/{$this->id}";
    }

    public function pathAnchor()
    {
        return "#comment-{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
