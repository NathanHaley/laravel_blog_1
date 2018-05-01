<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyPostsTest extends TestCase
{
    use RefreshDatabase;

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

}