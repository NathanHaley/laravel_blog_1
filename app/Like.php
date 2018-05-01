<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Like extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function liked()
    {
        return $this->morphTo();
    }

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

        return $type === null ? $likables : $likables[$type];
    }

    static function validations($type)
    {
        return [
            'liked_id' => 'required|exists:' . static::likables($type)['table'],
            'liked_type' => 'required|in:' . static::likables($type)['class'],
        ];
    }
}
