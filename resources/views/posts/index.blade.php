@extends('layouts.blog')

@section('content')
    <div class="col-md-10">
        <div class="d-flex h1">
            <div><span class="small">Posts By</span> {{ $user->name }}</div>
            <span class="ml-2">
                @include('layouts._follow-button')
            </span>
            <div class="ml-auto"><avatar username="{{ $user->name }}" avatar_path="{{ $user->avatar_path }}"></avatar></div>
        </div>
        <p class="text-muted">(By Most Recent)</p>
        <hr>
        @foreach($posts as $post)

            @include('posts._card')

            {{--<div class="card mt-5">--}}
                {{--@auth--}}
                    {{--<div class="card-header"></div>--}}
                {{--@endauth--}}
                {{--<div class="card-body">--}}
                    {{--<h5 class="card-title">{{ $post->title }}</h5>--}}
                    {{--<h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->format('n-d-Y') }}</h6>--}}
                    {{--<p class="card-text">{{ $post->body }}</p>--}}
                    {{--<a href="{{ route('post.show', $post) }}" class="card-link">Read more...</a>--}}
                {{--</div>--}}
                {{--@can('update')--}}
                    {{--<div class="card-footer"></div>--}}
                {{--@endcan--}}
            {{--</div>--}}

        @endforeach
    </div>

@endsection