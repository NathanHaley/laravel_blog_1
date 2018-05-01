<?php

namespace Tests\Feature;

use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_view_the_home_page()
    {
        $this->get('/')->assertStatus(200);
    }
}