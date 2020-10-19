<?php

namespace Tests\Unit;


use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    protected $thread, $user, $channel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class);
        $this->channel = create(Channel::class);
        $this->thread = create(Thread::class);
    }

    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    function test_a_thread_has_an_owner()
    {
        self::assertInstanceOf('App\User', $this->thread->creator);
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'foo',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    function test_a_thrad_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

}
