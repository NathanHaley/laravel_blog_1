<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_can_add_an_avatar()
    {   create('post');
        $this->signIn();
        $user = auth()->user();
        $this->get(route('profile', $user))
            ->assertSee('avatar-form');
    }

    /** @test */
    public function guests_can_not_add_an_avatar()
    {
        $user = create('user');
        create('post');

        $this->get(route('profile', $user))
            ->assertDontSee('avatar-form');
    }



//    /** @test */
//    public function authenticated_users_can_upload_an_avatar()
//    {
//        $this->signIn()->withExceptionHandling();
//
//        $user = auth()->user();
//
//        $this->post("profile/{$user->id}/avatar/create", '');
//    }
//
//    /** @test */
//    public function only_members_can_add_avatars()
//    {
//        $this->withExceptionHandling();
//
//        $this->json('POST', 'api/users/1/avatar')
//            ->assertStatus(401);
//    }
//
//    /** @test */
//    public function a_valid_avatar_must_be_provided()
//    {
//        $this->withExceptionHandling()->signIn();
//
//        $this->json('POST', 'api/users/'.auth()->id().'/avatar', [
//            'avatar' => 'not-an-image'
//        ])->assertStatus(422);
//    }
//
//    /** @test */
//    public function a_user_may_add_an_avatar_to_their_profile()
//    {
//        $this->signIn();
//
//        Storage::fake('public');
//
//        $this->json('POST', 'api/users/'.auth()->id().'/avatar', [
//            'avatar' => $file =  UploadedFile::fake()->image('avatar.jpg')
//        ]);
//
//        $this->assertEquals('/storage/avatars/'.$file->hashName(), auth()->user()->avatar_path);
//
//        Storage::disk('public')->assertExists('avatars/'.$file->hashName());
//    }
}