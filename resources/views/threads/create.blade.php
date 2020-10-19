@extends('layouts.app')

@section('title', 'Create New Thread')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Creata a new thread</div>
                    <div class="panel-body">
                        <form action="/threads" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id">Choose a Channel</label>
                                <select name="channel_id" id="channel_id" class="form-control">
                                    <option disabled>Choose one...</option>
                                    @foreach(App\Channel::all() as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>
                                            {{$channel->slug}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">

                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="{{old('title')}}">

                            </div>

                            <div class="form-group">

                                <label for="body">Body</label>

                                <textarea name="body" id="body" class="form-control" rows="8">{{old('body')}}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit">Publish</button>
                            </div>

                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>
                                            {{$error}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
