@extends('layouts.blog')

@section('content')
    <h1>Edit Post</h1>
    <hr>

    <form method="POST" action="/post/{{ $post->slug }}">
        @method('PATCH')
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input name="title" type="input" class="form-control" id="title"
                   placeholder="Something Informative About The Post"
                   value="{{ old('title') ?? $post->title }}"
                   required>
        </div>
        <div class="form-group">
            <label for="lede">Lede</label>
            <textarea name="lede" class="form-control" id="lede" rows="2"
                      placeholder="Just the interesting bits go here..."
                      required>{{ old('lede') ?? $post->lede }}</textarea>
        </div>
        <div class="form-group">
            <label for="channel">Channel</label>
            <select name="channel_id" class="form-control" id="channel_id" required>
                <option value="">Pick One</option>
                @foreach($channels as $channel)
                    <option value="{{ $channel->id }}"
                            @if(old('channel_id') ?? $post->channel_id == $channel->id) selected @endif>{{ $channel->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <wysiwyg id="body" name="body" value="{{ old('body') ?? $post->body }}"></wysiwyg>
            {{--<textarea name="body" class="form-control" id="body" rows="8"--}}
                      {{--placeholder="What do you have to say?"--}}
                      {{--required>{{ old('body') ?? $post->body }}</textarea>--}}
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Post</button>
        </div>
    </form>

    @include('layouts._errors')


@endsection