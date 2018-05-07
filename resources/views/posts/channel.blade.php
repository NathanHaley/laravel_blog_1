@extends('layouts.blog')

@section('header')
    <style type="text/css">
        .post-card {
            position: relative;
        }

        .post-card-avatar {
            position: absolute;
            top: -2em;
            left: 45%;
            z-index: 2;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-10">
        <div class="jumbotron p-3 p-md-5 text-white rounded" style="background-color: {{ $channel->color }};">
            <div class="col-md-6 px-0">
                <h1 class="display-4 font-italic">{{ $channel->name }}</h1>
             </div>
        </div>
        <p class="text-muted">(By Most Recent)</p>
        <hr>
        @forelse($posts as $post)

            @include('posts._card', ['show_avatar' => true])

        @empty
            <p>No posts for this channel at this time.</p>
        @endforelse
    </div>

@endsection