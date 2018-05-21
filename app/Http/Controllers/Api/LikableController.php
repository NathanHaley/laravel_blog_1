<?php

namespace App\Http\Controllers\Api;

use App\Post;

class LikableController extends ApiController
{
    public function __construct()
    {
        $this->middleware(['auth', 'confirmed']);
    }


    /**
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function likePost(Post $post)
    {
        try {
            $post->like();
        } catch (\Throwable $e) {
            return $this->respondInternalError();
        }

        return $this->respondCreated("Post like created");
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function unLikePost(Post $post)
    {
        try {
            $post->unlike();
        } catch (\Throwable $e) {
            return $this->respondInternalError();
        }

        return $this->respond("Post like destroyed");
    }

}
