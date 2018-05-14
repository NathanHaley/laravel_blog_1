<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'confirmed'])->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        return  $post->comments()->paginate(2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Post $post
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Post $post, Request $request)
    {
        $this->authorize('create', Comment::class);

        $validData = $request->validate(Comment::validations());

        $post->commentsCountIncrement();

        return $post->addComment([
            'user_id' => auth()->id(),
            'body' => $validData['body']
        ])->load('user');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->validate($comment->validations($comment->id)));

        return response(['status' => 'Comment updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        $comment->post->commentsCountDecrement();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    public function like(Post $post, Comment $comment)
    {
        $comment->like();
    }

    public function unlike(Post $post, Comment $comment)
    {
        $comment->unlike();
    }
}
