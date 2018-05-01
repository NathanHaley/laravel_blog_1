<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_can_add_an_avatar()
    {
        $this->signIn();
        $user = auth()->user();
        $this->get(route('profile', $user))
            ->assertSee('avatar-form');
    }

    /** @test */
    public function guests_can_not_add_an_avatar()
    {
        $user = create('user');

        $this->get(route('profile', $user))
            ->assertDontSee('avatar-form');
    }
}