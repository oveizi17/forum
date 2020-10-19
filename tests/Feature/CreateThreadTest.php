<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    private $channel, $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->channel = create(Channel::class);
        $this->user = create(User::class);
    }

    function test_an_authenticated_user_can_create_new_forum_threads()
    {
        //Give a new signedIn user
        $this->signIn();

        //We create a new thread
        $thread = make(Thread::class);

        //We post this thread to the server
        $response = $this->post('/threads', $thread->toArray());


        //We visit the thread page to check if it's created
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }

    function test_guest_cannot_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect(route('login'));

        $this->post('/threads')
            ->assertRedirect(route('login'));
    }

    function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    function test_a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }


    private function publishThread(array $array = [])
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = make(Thread::class, $array);

        return $this->post('/threads', $thread->toArray());
    }

    function test_an_authorized_user_can_delete_threads_and_replies_related_to_the_thread()
    {
        $this->signIn($this->user);


    }

    function test_unauthorized_users_cannot_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);


        $this->delete($thread->path())
            ->assertRedirect(route('login'));

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }


}
