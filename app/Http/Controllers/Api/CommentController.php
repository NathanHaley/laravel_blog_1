<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Comment as CommentResource;
use App\Post;
use App\Comment as CommentModel;
use Illuminate\Http\Request;
use App\Http\Resources\CommentCollection;
use Symfony\Component\HttpFoundation\Response as Http;

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

        $comments = $post->comments()->paginate(5);
        $commentsCollection = new CommentCollection($comments);

        return $this->respond($commentsCollection);

    }

}
