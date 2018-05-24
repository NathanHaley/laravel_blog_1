<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function members_can_create_comments_on_posts()
    {
        $this->signIn();

        $post = create('post');

        $comment = make('comment', ['post_id' => $post->id, 'user_id' => auth()->id()])->toArray();

        $this->post(route('comment.store', $post), $comment);

        $this->assertEquals($comment['body'], $post->comments->first()->body);
    }

    /** @test */
    public function members_can_update_their_comment()
    {
        $this->signIn();

        $comment = create('comment', ['user_id' => auth()->id()]);
        $post = $comment->post;

        $comment = $comment->toArray();

        $comment['body'] = 'Test Comment Body';

        $this->patch(route('comment.update', $comment['id']), $comment);

        $this->assertEquals($comment['body'], $post->fresh()->comments->first()->body);
    }

    /** @test */
    public function guests_can_not_create_comments_on_posts()
    {
        $this->withExceptionHandling();

        $post = create('post');

        $comment = make('comment')->toArray();

        $this->post(route('comment.store', $post), $comment)
            ->assertRedirect('login');

        $this->assertCount(0, $post->comments);
    }

    /** @test */
    public function guests_can_not_update_a_comment()
    {
        $this->signIn()->withExceptionHandling();

        $comment = create('comment', ['user_id' => auth()->id()]);
        $post = $comment->post;

        $originalCommentBody = $comment->body;

        $comment = $comment->toArray();

        $comment['body'] = 'Test Comment Body';

        $this->signOut();

        $this->patch(route('comment.update', $comment['id']), $comment)
            ->assertRedirect('login');

        $this->assertEquals($originalCommentBody, $post->fresh()->comments->first()->body);

    }

    /** @test */
    public function guests_can_not_delete_a_comment()
    {
        $this->signIn()->withExceptionHandling();

        $comment = create('comment', ['user_id' => auth()->id()]);
        $post = $comment->post;

        $this->assertCount(1, $post->comments);

        $this->assertEquals($comment->body, $post->comments->first()->body);

        $this->signOut();

        $this->delete(route('comment.destroy', $comment))
            ->assertRedirect('login');

        $this->assertEquals($comment->body, $post->fresh()->comments->first()->body);
    }

    /** @test */
    public function members_can_delete_their_comment()
    {
        $this->signIn();

        $comment = create('comment', ['user_id' => auth()->id()]);
        $post = $comment->post;

        $this->assertCount(1, $post->comments);

        $this->assertEquals($comment->body, $post->comments->first()->body);

        $this->delete(route('comment.destroy', $comment));

        $this->assertCount(0, $post->fresh()->comments);
    }

    /** @test */
    public function members_can_not_update_another_users_comment()
    {
        $this->signIn()->withExceptionHandling();

        $user = create('user');

        $comment = create('comment', ['user_id' => $user->id]);
        $post = $comment->post;

        $comment = $comment->toArray();

        $comment['body'] = 'Test Comment Body';

        $this->patch(route('comment.update', $comment['id']), $comment)
            ->assertSee('This action is unauthorized');

    }

    /** @test */
    public function members_can_not_delete_another_users_comment()
    {
        $this->signIn()->withExceptionHandling();

        $user = create('user');

        $comment = create('comment', ['user_id' => $user->id]);
        $post = $comment->post;

        $this->assertCount(1, $post->comments);

        $this->assertEquals($comment->body, $post->comments->first()->body);

        $this->delete(route('comment.destroy', $comment))
            ->assertSee('This action is unauthorized');
    }

    /** @test */
    public function admins_can_update_a_user_comment()
    {
        $this->signInAdmin();

        $user = create('user');

        $comment = create('comment', ['user_id' => $user->id]);
        $post = $comment->post;

        $comment = $comment->toArray();

        $comment['body'] = 'Test Comment Body';

        $this->patch(route('comment.update', $comment['id']), $comment);

        $this->assertEquals($comment['body'], $post->fresh()->comments->first()->body);
    }

    /** @test */
    public function admins_can_delete_a_user_comment()
    {
        $this->signInAdmin();

        $user = create('user');

        $comment = create('comment', ['user_id' => $user->id]);
        $post = $comment->post;

        $this->assertCount(1, $post->comments);

        $this->assertEquals($comment->body, $post->comments->first()->body);

        $this->delete(route('comment.destroy', $comment));

        $this->assertCount(0, $post->fresh()->comments);
    }


}