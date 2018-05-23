<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function notifications_are_generated_when_followed_user_creates_a_post()
    {


        $this->assertNotCount(0, config('blog.administrators'));
    }
}