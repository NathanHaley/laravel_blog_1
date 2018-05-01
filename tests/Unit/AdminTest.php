<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function at_least_one_admin_is_configured()
    {
        $this->assertNotCount(0, config('blog.administrators'));
    }
}