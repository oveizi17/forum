@extends('layouts.app')

@section('title', "{$thread->title}")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href=""> {{ $thread->creator->name }}</a>
                        posted {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                    <div class="card-footer">
                        @can ('update', $thread)
                            <form action="{{ $thread->path() }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-link">Delete Thread</button>
                            </form>
                        @endcan
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{ $replies->links() }}

                @auth()
                    <div class="card-footer">
                        <form action="{{ $thread->path().'/replies' }}" method="POST">
                            @csrf

                            <textarea
                                name="body"
                                id="body"
                                rows="5"
                                cols="50"
                                placeholder="Have something to say?"
                            ></textarea>
                            <button type="submit" class="btn">Reply</button>

                        </form>
                        @else
                            <p class="text-center">Please <a href="{{ route('login') }}">
                                    login in
                                </a> to reply to this thread.</p>
                    </div>
                @endauth
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>This thread was posted
                        {{ $thread->created_at->diffForHumans() }}
                         by {{ $thread->creator->name }}.
                         This thread has {{ $thread->replies_count }}
                         {{ Str::plural('reply',$thread->replies_count) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
