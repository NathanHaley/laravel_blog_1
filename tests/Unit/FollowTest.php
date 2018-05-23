<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_can_follow_another_member()
    {
        $this->signIn();

        $user = create('user');

        $this->post(route('follow', $user))
            ->assertStatus(Http::HTTP_CREATED);

        $this->assertEquals(1, $this->userFollowedByCount($user->id));
    }

    /** @test */
    public function guests_can_not_follow_members()
    {
        $this->withExceptionHandling();

        $user = create('user');

        $this->post(route('follow', $user))
            ->assertStatus(Http::HTTP_UNAUTHORIZED)
            ->assertSee('Unauthenticated');

        $this->assertEquals(0, $this->userFollowedByCount($user->id));
    }

    /** @test */
    public function members_can_unfollow_another_member()
    {
        $this->signIn();

        $user = create('user');

        $this->post(route('follow', $user));

        $this->assertEquals(1, $this->userFollowedByCount($user->id));

        $this->delete(route('unfollow', $user))
            ->assertStatus(Http::HTTP_NO_CONTENT);

        $this->assertEquals(0, $this->userFollowedByCount($user->id));
    }

    /**
     * |--------------------------------------------------------------------------
     * | Helpers
     * |--------------------------------------------------------------------------
     */

    public function userFollowedByCount(int $userId)
    {
        return DB::table('user_follows')
            ->where('follow_id', '=', $userId)
            ->count();
    }
}