<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    /*
     * Constructor
     */


    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * @param $channelId
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (\request()->wantsJson()) {
            return $threads;
        }
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \request()->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',

        ]);

        $thread = Thread::create([
            'title' => \request('title'),
            'body' => \request('body'),
            'user_id' => auth()->id(),
            'channel_id' => \request('channel_id'),
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param $channel
     * @param \App\Thread $thread
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function show($channel, Thread $thread)
    {

        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $channelSlug
     * @param \App\Thread $thread
     */
    public function destroy($channelSlug, Thread $thread)
    {
       // $thread->remove(auth()->user());
       $this->authorize('update', $thread);

       $thread->delete();

        if (\request()->wantsJson()) {
            return response([], 204);
        }

        return back();
    }

    private function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters);

        if ($channel->exists) {
            $threads->whereChannelId($channel->id);
        }

        return $threads->paginate(20);
    }


}
