<?php

namespace Tests\Feature;

use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_access_channels_area()
    {
        $this->signInAdmin();

        $this->get(route('admin.channel.index'))
            ->assertSee('Add A Channel');
    }

    /** @test */
    public function non_admins_can_not_access_channels_area()
    {
        $this->withExceptionHandling();

        $this->get(route('admin.channel.index'))
            ->assertSee('You do not have permission.');

        $this->signIn();

        $this->get(route('admin.channel.index'))
            ->assertSee('You do not have permission.');
    }

    /** @test */
    public function admins_can_create_channels()
    {
        $this->signInAdmin();

        $channel = make('channel')->toArray();

        $this->post(route('admin.channel.store', $channel))
            ->assertRedirect(route('admin.channel.index'));

        $this->get(route('admin.channel.index'))
            ->assertSee($channel['name']);
    }

    /** @test */
    public function non_admins_can_not_create_channels()
    {
        $this->withExceptionHandling();

        $channel = make('channel')->toArray();

        $this->post(route('admin.channel.store'), $channel)
            ->assertSee('You do not have permission.');

        $this->signIn();

        $this->post(route('admin.channel.store'), $channel)
            ->assertSee('You do not have permission.');
    }

    /** @test */
    public function admins_can_update_channels()
    {
        $this->signInAdmin();

        $channel = create('channel')->toArray();

        $this->get(route('admin.channel.edit', $channel['slug']))
            ->assertSee('Edit A Channel')
            ->assertSee($channel['description']);

        $channel['name'] = 'Updated Name';

        $this->patch(route('admin.channel.update', $channel['slug']), $channel)
            ->assertRedirect(route('admin.channel.index'));

        $this->get(route('admin.channel.index'))
            ->assertSee($channel['description']);

    }

    /** @test */
    public function non_admins_can_not_update_channels()
    {
        $this->withExceptionHandling();

        $channel = create('channel')->toArray();

        $channel['name'] = 'Updated Name';

        $this->get(route('admin.channel.edit', $channel['slug']))
            ->assertSee('You do not have permission.');

        $this->patch(route('admin.channel.update', $channel['slug']), $channel)
            ->assertSee('You do not have permission.');

        $this->signIn();

        $this->get(route('admin.channel.edit', $channel['slug']))
            ->assertSee('You do not have permission.');

        $this->patch(route('admin.channel.update', $channel['slug']), $channel)
            ->assertSee('You do not have permission.');

    }

    /** @test */
    public function admins_can_archive_channels()
    {
        $this->signInAdmin();

        $channel = create('channel');

        $this->delete(route('admin.archive-channel.destroy', $channel['slug']))
            ->assertRedirect(route('admin.channel.index'));

        $this->assertNotNull($channel->fresh()->deleted_at);
    }

    /** @test */
    public function non_admins_can_not_archive_channels()
    {
        $this->withExceptionHandling();

        $channel = create('channel');

        $this->delete(route('admin.archive-channel.destroy', $channel['slug']))
            ->assertSee('You do not have permission.');

        $this->signIn();

        $this->delete(route('admin.archive-channel.destroy', $channel['slug']))
            ->assertSee('You do not have permission.');
    }

}