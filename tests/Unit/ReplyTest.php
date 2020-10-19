<?php

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase {

    use RefreshDatabase;


    private $user, $channel, $thread;


    public function setUp(): void
    {
        parent::setUp();

        $this->user = create(\App\User::class);
        $this->channel = create(Channel::class);
        $this->thread = create(Thread::class);
    }

    public function test_it_has_an_owner()
    {

        $reply = create(Reply::class);


        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
