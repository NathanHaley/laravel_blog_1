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


    /** @test */
    public function members_can_view_a_list_of_their_posts()
    {
        $this->signIn();

        $userId = auth()->id();

        $title = create('post', ['user_id' => $userId])->title;

        $this->get(route('user-posts', auth()->user()))
            ->assertSee($title);
    }

    /** @test */
    public function guests_can_not_view_a_list_of_their_posts_for_edit()
    {
        $user = create('user');

        $userId = $user->id;

        $titles = [];
        for ($i = 0; $i < 5; ++$i) {
            $titles = array_prepend($titles, create('post', ['user_id' => $userId])->title);
        }

        $this->get(route('home'))
            ->assertDontSee('My Posts');

        $this->get(route('user-posts', $user))
            ->assertDontSee('Edit');
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
        $this->signIn();

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

    /** @test */
    public function authenticated_users_can_delete_their_post()
    {
        $this->signIn()->withExceptionHandling();

        $post = create('post', ['user_id' => auth()->id()])->toArray();

        $this->delete("post/{$post['slug']}", $post)
            ->assertRedirect(route('user-posts', auth()->user()))
            ->assertDontSee($post['title']);
    }

    /** @test */
    public function admins_can_delete_another_users_post()
    {
        $this->signInAdmin();

        $user = create('user');
        $post = create('post', ['user_id' => $user->id])->toArray();

        $this->delete("post/{$post['slug']}", $post)
            ->assertRedirect(route('user-posts', $user))
            ->assertDontSee($post['title']);
    }

    /** @test */
    public function admins_can_update_another_users_post()
    {
        $this->signInAdmin();

        $user = create('user');
        $post = create('post', ['user_id' => $user->id])->toArray();

        $this->get("post/{$post['slug']}/edit")
            ->assertSee('Edit Post')
            ->assertSee($post['title']);

        $post['title'] = 'Updated Title';

        $this->patch("post/{$post['slug']}", $post)
            ->assertRedirect(route('user-posts', $user));

        $this->get(route('user-posts', $user))
            ->assertSee($post['title']);
    }

    /** @test */
    public function authenticated_users_can_not_delete_another_users_post()
    {
        $this->signIn()->withExceptionHandling();

        $post = create('post', ['user_id' => create('user')->id])->toArray();

        $this->delete("post/{$post['slug']}", $post)
            ->assertSee('Unauthorized');
    }

    /** @test */
    public function guests_can_not_delete_a_post()
    {
        $this->signIn()->withExceptionHandling();

        $post = create('post', ['user_id' => auth()->id()])->toArray();

        $this->signOut();

        $this->delete("post/{$post['slug']}", $post)
            ->assertSee('login');
    }

}