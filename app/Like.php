<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 * @package App
 */
class Like extends Model
{
    use RecordsActivity;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'liked_id',
        'liked_type'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function liked()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param null $type
     * @return array|bool
     */
    static function likables($type = null)
    {

        $likables = [
            'user' => [
                'class' => 'App\User',
                'table' => 'users'
            ],
            'post' => [
                'class' => 'App\Post',
                'table' => 'posts'
            ],
            'comment' => [
                'class' => 'App\Comment',
                'table' => 'comments'
            ],
        ];

        return $type === $likables[$type] ?? $likables;
    }

    /**
     * @param $type
     * @return array
     */
    static function validations($type)
    {
        return [
            'liked_id' => 'required|exists:' . static::likables($type)['table'],
            'liked_type' => 'required|in:' . static::likables($type)['class'],
        ];
    }
}
