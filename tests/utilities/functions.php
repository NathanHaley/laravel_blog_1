<?php
//Nathan's, Jeffery's, helper functions

function classAliasConvert($class)
{
    $aliasList = [
        'user' => 'App\User',
        'post' => 'App\Post',
        'channel' => 'App\Channel'
    ];
    return $aliasList[$class] ?? $class;
}

function create($class, $attributes = [], $times = null)
{
    return factory(classAliasConvert($class), $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory(classAliasConvert($class), $times)->make($attributes);
}
