<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'confirmed'])->except(['index', 'show', 'channel', 'archives']);
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

    public function archives(int $year, string $monthName)
    {
        $breakPoint = Post::breakPoint();

        $archives = Post::archives($breakPoint);

        $posts = Post::whereYear('created_at', $year)->whereMonth('created_at', Carbon::parse($monthName)->month)->orderby('created_at', 'desc')->get();

        return view('posts.archives', compact('posts', 'archives', 'year', 'monthName'));
    }

    /**
     * Display a listing of posts for a channel.
     *
     * @return \Illuminate\Http\Response
     */
    public function channel(Channel $channel)
    {
        $posts = $channel->posts;

        return view('posts.channel', compact('posts', 'channel'));
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

        $banner_path = null;
        $card_path = null;

        if ($request->hasFile('banner_path')) {

            $banner_path = request()->file('banner_path')->store('posts/images', 'public');

        }

        if ($request->hasFile('card_path')) {

            $card_path = request()->file('card_path')->store('posts/images', 'public');

        }


        Post::create([
            'user_id' => auth()->id(),
            'channel_id' => $validData['channel_id'],
            'banner_path' => $banner_path,
            'card_path' => $card_path,
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

        //$post = new \App\Http\Resources\Post($post);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

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

        return redirect(route('user-posts', $post->user->name))->with('flash', [
            'type' => 'success',
            'message' => 'Post updated.'
        ]);
    }

    /**
     * Show and confirm remove action for specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        return view('posts.delete', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $name = $post->user->name;

        $post->delete();

        return redirect(route('user-posts', $name))->with('flash', [
            'type' => 'danger',
            'message' => 'Post deleted.'
        ]);
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
