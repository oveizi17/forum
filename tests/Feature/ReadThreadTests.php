<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadTests extends TestCase
{

    use RefreshDatabase;

    private $user, $channel, $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = create(User::class);

        $this->channel = create(Channel::class);

        $this->thread = create(Thread::class);

    }

    public function test_a_thread_can_be_seen_in_a_view()
    {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);


    }

    public function test_a_user_can_read_a_single_thread()
    {

        $this->get($this->thread->path())
            ->assertSee($this->thread->title);

    }

    public function test_a_user_can_read_replies_that_are_linked_to_a_thread()
    {
        $reply = create(Reply::class);


        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);

        $threadInChannel = create(Thread::class, [
            'channel_id' => $channel->id,
        ]);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($this->thread->title);
    }

    function test_a_user_can_filter_threads_by_any_username()
    {

        $this->signIn(create(User::class, ['name' => 'JohnDoe']));


        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);

        $threadNotByJohn = create(Thread::class);


        $this->get('/threads?by=JohnDoe')
            ->assertDontSee($threadNotByJohn->title)
            ->assertSee($threadByJohn->title);

    }

//    function test_a_user_can_filter_threads_by_popularity()
//    {
//        $threadWithTwoReply = create(Thread::class);
//        $reply = create(Reply::class, ['thread_id' => $threadWithTwoReply->id],2);
//
//        $threadWithThreeReply = create(Thread::class);
//        $replies = create(Reply::class, ['thread_id' => $threadWithThreeReply->id],3);
//
//        $threadsWithNoReply = $this->thread;
//
//
//
//        $response = $this->getJson('/threads?popular=1')->json();
//
//
//        $this->assertEquals([3,2,1,0], array_column($response, 'replies_count'));
//    }
}
