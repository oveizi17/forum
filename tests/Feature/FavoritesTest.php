<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $thread;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $user;
    private $channel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class);
        $this->channel = create(Channel::class);
        $this->thread = create(Thread::class);
    }


    function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);


        $this->post('/replies/'. $reply->id.'/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    function test_guests_cannot_favorite_anything()
    {
        $this->withExceptionHandling();
        create(Reply::class);

        $this->post('/replies/1/favorites')
            ->assertRedirect(route('login'));
    }

    function test_an_authenticated_user_can_favorite_only_once_a_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('/replies/'.$reply->id.'/favorites');
        $this->post('/replies/'.$reply->id.'/favorites');

        $this->assertDatabaseCount('favorites',1);
    }

}
