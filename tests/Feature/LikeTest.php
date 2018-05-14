<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_can_like_and_unlike_a_post()
    {
        $this->signIn();

        $post = create('post');

        $post->like();

        $this->assertEquals(1, $post->likes_count);

        $post->unLike();

        $this->assertEquals(1, $post->likes_count);

    }

    /** @test */
    public function guests_can_not_like_a_post()
    {
        $this->withExceptionHandling();
        $post = create('post');

        $response = $this->post(route('post.like', $post))->assertRedirect('login');

        $this->assertEquals(0, $post->likes_count);

    }

    /** @test */
    public function guests_can_not_unlike_a_post()
    {

        $this->signIn();

        $post = create('post');

        $post->like();

        $this->signOut();

        $post->unLike();

        $this->assertEquals(1, $post->likes_count);

    }
}