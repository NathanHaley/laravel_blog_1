<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package App
 */
class Comment extends Model
{
    use LikableTrait;

    /**
     * @var array
     */
    protected $with = ['user', 'post'];

    /**
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'body'
    ];

    /**
     * @var array
     */
    protected $appends = ['path', 'isLiked', 'likedCount'];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * @param null $id
     * @return array
     */
    static function validations($id = null)
    {
        return [
            'body' => 'required|max:500',
        ];
    }

    /**
     * @param $body
     * @return array|string
     */
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

    /**
     * @return string
     */
    public function path()
    {
        return $this->post->path()."/comment/{$this->id}";
    }

    /**
     * @return string
     */
    public function getPathAttribute()
    {
        return $this->post->path()."/comment/{$this->id}";
    }

    /**
     * @return string
     */
    public function pathAnchor()
    {
        return "#comment-{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() {
        return $this->belongsTo(Post::class);
    }
}
