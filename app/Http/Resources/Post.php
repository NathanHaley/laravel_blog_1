<?php

//TODO: Not used yet.

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->slug,
            'body' => $this->body,
            'isLiked' => $this->isLiked(),
            'likes_count' => $this->likes_count,
            'created_at' => $this->created_at,
            'path' => $this->path,
            'user' => new User($this->user),
            'comments' => $this->comments()->paginate(1)
        ];

    }
}
