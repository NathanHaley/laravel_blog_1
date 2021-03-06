<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'confirmed' => true,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'notConfirmed', function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'confirmed' => false,
        'confirmation_token' => 'secret',
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'admin', function (Faker $faker) {
    return [
        'name' => 'JoeTest',
        'email' => config('blog.administrators')[0],
        'confirmed' => true,
        'password' => Hash::make('testtt'),
        'remember_token' => str_random(10),
    ];
});

//$factory->state(App\User::class, 'administrator', function () {
//    return [
//        'email' => config('blog.administrators')[0]
//    ];
//});

$factory->define(App\Post::class, function (Faker $faker) {
    $title = $faker->unique()->sentence();

    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(\App\Channel::class)->create()->id;
        },
        'title' => $title,
        'slug' => str_slug($title),
        'lede' => $faker->paragraph,
        'body'  => $faker->text(rand(400, 2000)),
        'visits' => 0,
        'locked' => false
    ];
});

$factory->state(App\Post::class, 'from_existing_channels_and_users', function (Faker $faker) {
    $title = $faker->unique()->sentence();

    return [
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'channel_id' => function () {
            return \App\Channel::all()->random()->id;
        },
        'title' => $title,
        'slug' => str_slug($title),
        'lede' => $faker->paragraph(),
        'body'  => $faker->text(rand(400, 2000)),
        'visits' => $faker->numberBetween(0, 35),
        'locked' => $faker->boolean(15)
    ];
});

$factory->state(/**
 * @param Faker $faker
 * @return array
 */
    App\Post::class, 'from_existing_channels_and_users_with_banner', function (Faker $faker) {
    $title = $faker->unique()->sentence();
    $date = $faker->dateTimeBetween('-2 years');

    return [
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'channel_id' => function () {
            return \App\Channel::all()->random()->id;
        },
        'title' => $title,
        'slug' => str_slug($title),
        'lede' => $faker->paragraph(),
        'body'  => $faker->text(rand(400, 2000)),
        'banner_path' => 'https://placeimg.com/1000/250/any/'.rand(1, 1000),
        'visits' => $faker->numberBetween(0, 35),
        'locked' => $faker->boolean(15),
        'created_at' => $date,
        'updated_at' => $date
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(3);

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'description'  => $faker->paragraph,
        'color' => '#'.dechex(rand(0x000000, 0xFFFFFF))
    ];
});

$factory->define(App\Comment::class, function (Faker $faker) {

    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'post_id' => function () {
            return factory(\App\Post::class)->create()->id;
        },
        'body'  => $faker->paragraph,
    ];
});

$factory->state(App\Comment::class, 'from_existing_posts_and_users', function (Faker $faker) {

    return [
        'user_id' => function () {
            return \App\User::all()->random()->id;
        },
        'post_id' => function () {
            return \App\Post::all()->random()->id;
        },
        'body'  => $faker->paragraph,
    ];
});


