<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
                'id' => $this->id,
                'body' => $this->body,
                'isLiked' => $this->isLiked(),
                'likes_count' => $this->likes_count,
                'created_at' => $this->created_at,
                'path' => route('comment.like', ['post' => $this->post, 'comment' => $this]),
                'user' => [
                    'name' => $this->user->name,
                    'avatar_path' => $this->user->avatar_path,
                    'path' => $this->user->path,
                ],
        ];
    }
}
