<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', '']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $posts = $user->posts;

        return view('posts.index', compact('posts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = Channel::all();

        return view('posts.create', compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $validData = $request->validate(Post::validations());

        $banner_image = null;
        $card_image = null;

        if ($request->hasFile('banner_image')) {

            $banner_image = request()->file('banner_image')->store('posts/images', 'public');

        }

        if ($request->hasFile('card_image')) {

            $card_image = request()->file('card_image')->store('posts/images', 'public');

        }


        Post::create([
            'user_id' => auth()->id(),
            'channel_id' => $validData['channel_id'],
            'banner_path' => $banner_image,
            'card_path' => $card_image,
            'title' => $validData['title'],
            'lede' => $validData['lede'],
            'body' => $validData['body'],
        ]);

        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->visitsIncrement();

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $channels = Channel::all();

        return view('posts.edit', compact('post', 'channels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validData = $request->validate($post->validations($post->id));

        if ($request->hasFile('banner_path')) {

            $post->removeBannerImage();
            $validData['banner_path'] = request()->file('banner_path')->store('posts/images', 'public');

        }

        if ($request->hasFile('card_path')) {

            $post->removeCardImage();
            $validData['banner_path'] = request()->file('card_path')->store('posts/images', 'public');

        }

        $post->update($validData);

        return redirect(route('user-posts', auth()->user()->name))->with('flash', [
            'type' => 'success',
            'message' => 'Post updated.'
        ]);
    }

    /**
     * Show and confirm remove action for specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Post $post)
    {
        return view('posts.delete', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return void
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $name = $post->user->name;

        $post->delete();

        return redirect(route('profile', $name));
    }

    public function like(Post $post)
    {
        $post->like();
    }

    public function unlike(Post $post)
    {
        $post->unlike();
    }
}
