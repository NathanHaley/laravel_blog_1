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

        @endforeach
    </div>

@endsection