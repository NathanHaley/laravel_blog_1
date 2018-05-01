<?php

namespace App;

use App\Events\UserPublishedNewPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Post extends Model
{
    use RecordsActivity;
    use LikableTrait;

    protected $guarded = [];
    protected $recordableActivities = ['created', 'updated'];

    protected $dates = [
        'created_at',
        'updated_at',
    //    'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            event(new UserPublishedNewPost($post));
        });
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the name of the channel.
     *
     * @param string $name
     */
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = str_slug($title);
    }

    static function latestActive($limit = 3)
    {
        return static::latest()->limit($limit)->get();
    }

    public function visitsIncrement()
    {
        static::increment('visits');
    }

    public function commentsCountIncrement()
    {
        static::increment('comments_count');
    }

    public function commentsCountDecrement()
    {
        static::decrement('comments_count');
    }

    static function validations($id = null)
    {
        return [
            'title' => [
                'required',
                $id === null ? '' : Rule::unique('posts')->ignore($id),
                'max:100',
            ],
            'lede' => 'required|max:250',
            'body' => 'required|max:65000',
            'channel_id' => 'required|exists:channels,id'
        ];
    }

    public function addComment(array $comment)
    {
        $comment = $this->comments()->create($comment);

//        event(new UserPublishedNewComment($comment));

        return $comment;
    }

    public function path()
    {
        return "/post/{$this->slug}";
    }

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderByDesc('created_at');
    }
}
