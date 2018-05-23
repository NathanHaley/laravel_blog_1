<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//TODO: Clean up routes

/**
 * |--------------------------------------------------------------------------
 * | Guest Routes
 * |--------------------------------------------------------------------------
 */
Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home'); //TODO: Remove this?
Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');

/**
 * |--------------------------------------------------------------------------
 * | Authenticated users
 * |--------------------------------------------------------------------------
 */

Route::get('post/create', 'PostController@create')->name('post.create');
Route::get('post/{post}/edit', 'PostController@edit')->name('post.edit');
Route::get('post/{post}/delete', 'PostController@delete')->name('post.delete');
Route::delete('post/{post}', 'PostController@destroy')->name('post.destroy');
Route::patch('post/{post}', 'PostController@update');
Route::post('post', 'PostController@store');
Route::get('post/{post}/show', 'PostController@show')->name('post.show');
Route::post('post/{post}/like', 'Api\LikableController@likePost')->name('post.like');
Route::delete('post/{post}/like', 'Api\LikableController@unlikePost')->name('post.unlike');

Route::get('posts/archive/year/{year}/month/{month}/{user?}', 'PostController@archives')
    ->where('year', '20[1-9]{2}')
    ->where('month','(January|February|March|April|May|June|July|August|September|October|November|December)' )
    ->name('post.archives');


///^\w*(January|February|March|April|May|June|July|August|September|October|November|December) \d{1,2}, \d{4}/igm

Route::get('post/{channel}', 'PostController@channel')->name('channel.posts');

Route::get('post/{post}/show/comment', 'Api\CommentController@index')->name('comment.list');
Route::post('post/{post}/show/comment', 'CommentController@store')->name('comment.create');
Route::patch('comment/{comment}', 'CommentController@update')->name('comment.update');
Route::delete('comment/{comment}', 'CommentController@destroy')->name('comment.destroy');
Route::post('comment/{comment}/like', 'CommentController@like')->name('comment.like');
Route::delete('comment/{comment}/like', 'CommentController@unlike')->name('comment.unlike');

Route::get('profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('user/{user}/posts', 'PostController@index')->name('user-posts');
//Route::get('/api/users', 'Api\UserController@index');

Route::post('follow/{user}', 'Api\UserFollowController@store')->name('follow');
Route::delete('follow/{user}', 'Api\UserFollowController@destroy')->name('unfollow');

Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::post('/profiles/{user}/like', 'ProfileController@like')->name('user.like');;
Route::delete('/profiles/{user}/like', 'ProfileController@unlike')->name('user.like');;
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('avatar');

/**
 * |--------------------------------------------------------------------------
 * | Administrators only
 * |--------------------------------------------------------------------------
 */
Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin',
    'namespace' => 'Admin'
], function () {
    Route::get('channel', 'ChannelController@index')->name('admin.channel.index');
    Route::get('channel/create', 'ChannelController@create')->name('admin.channel.create');
    Route::post('channel', 'ChannelController@store')->name('admin.channel.store');
    Route::patch('channel/{channel}', 'ChannelController@update')->name('admin.channel.update');
    Route::get('channel/{channel}/edit', 'ChannelController@edit')->name('admin.channel.edit');

    //Only allow soft deletes for archiving functionality
    ////Route::delete('channel', 'ChannelController@destroy');

    //Route::get('archived-channel/{channel}', 'ArchivedChannelController@show');
    Route::post('archived-channel/{id}', 'ArchivedChannelController@store')->name('admin.archive-channel.store');;
    //Route::patch('archived-channel/{channel}', 'ChannelController@destroy');
    Route::delete('archived-channel/{channel}', 'ArchivedChannelController@destroy')->name('admin.archive-channel.destroy');;
});






