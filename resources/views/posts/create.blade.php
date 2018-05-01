@extends('layouts.blog')

@section('header')
    <link href="{{ asset('css/vendor/trix.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Create A Post</h1>
                <hr>

                <form method="POST" action="/post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input name="title" type="input" class="form-control" id="title"
                               placeholder="Something Informative About The Post"
                               value="{{ old('title') }}"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="lede">Lede</label>
                        <textarea name="lede" class="form-control" id="lede" rows="2"
                                  placeholder="Just the interesting bits go here..."
                                  required>{{ old('lede') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="channel">Channel</label>
                        <select name="channel_id" class="form-control" id="channel_id" required>
                            <option value="">Pick One</option>
                            @foreach($channels as $channel)
                                <option value="{{ $channel->id }}"
                                        @if(old('channel_id') == $channel->id) selected @endif>{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <wysiwyg id="body" name="body" value="{{ old('body') }}" placeholder="The main body of your post..."></wysiwyg>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Post</button>
                    </div>
                </form>

                @include('layouts._errors')
            </div>
        </div>
    </div>

@endsection