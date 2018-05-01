<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_create_a_post()
    {
        $this->signIn();

        $this->get('/post/create')
            ->assertSee('Create A Post');

        $post = make('post')->toArray();

        $this->post('/post', $post)
            ->assertRedirect('home');

        $this->get('home')
            ->assertSee($post['title']);
    }


    public function authenticated_users_can_view_the_list_of_their_posts()
    {
        $this->signIn();

        $post = create('post', ['user_id' => auth()->id()])->toArray();

        $this->get("/post/{auth()->name()}")
            ->assertSee($post['title']);
    }

    /** @test */
    public function guests_can_not_create_posts()
    {
        $this->withExceptionHandling();

        $this->get('/post/create')
            ->assertRedirect(route('login'));

        $post = make('post')->toArray();

        $this->post('/post', $post)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_users_can_update_their_post()
    {
        $this->signInAdmin();

        $post = create('post', ['user_id' => auth()->id()])->toArray();

        $this->get("post/{$post['slug']}/edit")
            ->assertSee('Edit Post')
            ->assertSee($post['title']);

        $post['title'] = 'Updated Title';

        $this->patch("post/{$post['slug']}", $post)
            ->assertRedirect(route('user-posts', auth()->user()));

        $this->get('home')
            ->assertSee($post['title']);

    }


}