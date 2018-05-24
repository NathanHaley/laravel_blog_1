<?php

namespace App\Events;

use App\Post;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UserPublishedNewPost
 * @package App\Events
 */
class UserPublishedNewPost
{
    use Dispatchable, SerializesModels;

    /**
     * @var Post
     */
    public $post;

    /**
     * UserPublishedNewPost constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function subject()
    {
        return $this->post;
    }
}
