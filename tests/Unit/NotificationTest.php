<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_notification_is_created_when_followed_members_create_a_post()
    {
        $this->withExceptionHandling();

        $this->setupNotification();

        $this->assertEquals(1, $this->notificationCount());
    }

    /** @test */
    public function a_notification_is_removed_when_notified_member_visits_the_notification_link()
    {
        $this->withExceptionHandling();

        $this->setupNotification();

        $this->assertEquals(1, $this->notificationCount());

        $this->assertEquals(0, DB::table('notifications')->where('read_at', '!=', null)->count());;

        $this->delete(route('notification.destroy', DB::table('notifications')->first()->id))
            ->assertStatus(204);

        $this->assertNotNull(DB::table('notifications')->first()->read_at);
    }

    /**
     * |--------------------------------------------------------------------------
     * | Helpers
     * |--------------------------------------------------------------------------
     */

    public function setupNotification()
    {
        $this->signIn();

        $userA = auth()->user();

        $userB = create('user');

        $this->post(route('follow', $userB));

        $this->be($userB);

        $this->post(route('post.store'), make('post')->toArray());

        $this->be($userA);
    }

    public function notificationCount()
    {
        return DB::table('notifications')->count();
    }
}