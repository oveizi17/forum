<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateForumTest extends TestCase
{

    use RefreshDatabase;

    private $channel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->channel = create(Channel::class);
    }



    function test_an_authenticated_user_may_reply_in_forum_thread()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = make(Reply::class);



        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    function test_unautheticated_user_may_not_add_reply()
    {
        $this->withExceptionHandling();

        $this->post('/threads/someChannel/1/replies', [])
            ->assertRedirect(route('login'));
    }
}
