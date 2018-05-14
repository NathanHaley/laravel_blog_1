<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentCollection;

class CommentController extends ApiController
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
        $comments = new CommentCollection($post->comments()->paginate(2));

        return  $this->respond($comments);

    }

}
