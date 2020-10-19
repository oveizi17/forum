<?php

namespace Tests\Unit;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ActivitiesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $channel;

    protected function setUp(): void
    {
        parent::setUp(); //

        $this->channel = create(Channel::class);
    }

    public function test_stores_activites_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class,[
            'user_id' => auth()->id(),
        ]);

        $this->assertDatabaseHas('activities',[
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id,$thread->id);

    }

    public function test_stores_activites_when_a_reply_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $reply = create(Reply::class);

        $this->assertDatabaseHas('activities',[
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => 'App\Reply',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id,$reply->id);
    }

    function test_it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        $threadNow = create(Thread::class);
        $threadFromWeekAgo = create(Thread::class,['created_at' => Carbon::now()->subWeek()]);

        auth()->user()->activities()->first()->update(
            ['created_at' => Carbon::now()->subWeek()]
        );

        $feed = Activity::feed(auth()->user());

        self::assertTrue($feed->keys()->contains(
            Carbon::now()->format('d-M-Y')
        ));

        self::assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('d-M-Y')
        ));
    }

}
