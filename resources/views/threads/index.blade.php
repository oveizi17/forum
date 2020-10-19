@extends('layouts.app')

@section('title', 'All Threads')
@section('content')

    <div class="container">
        <div class="list-group">

            @foreach($threads as $thread)

                <a href="{{ $thread->path() }}" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $thread->title }}</h5>
                        <small>{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}</small>
                    </div>
                    <p class="mb-1">{{ $thread->body }}</p>
                    <small>{{ $thread->creator->name }}</small>
                </a>

            @endforeach

            {{ $threads->links() }}
        </div>
    </div>
@endsection
