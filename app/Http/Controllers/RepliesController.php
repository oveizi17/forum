<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{


    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * @param $channelId
     * @param Thread $thread
     */
    public function store($channelId, Thread $thread)
    {
        $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
