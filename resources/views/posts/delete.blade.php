@extends('layouts.blog')

@section('header')
    <link href="{{ asset('css/vendor/trix.css') }}" rel="stylesheet">
@endsection

@section('content')
    <post-show :post="{{ $post }}" inline-template>
        <div class="container">
            <div class="col-md-12">
                <div class="alert-danger rounded p-4">
                    Are you sure you would like to remove this post permanently?
                    <form action="{{route('post.destroy', $post)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-4">Yes</button>
                    </form>
                </div>

                <div class="text-center">
                    <h1 class="h1">
                        {{ $post->title }}
                    </h1>
                    <h4 style="color: {{ $post->channel->color }};">
                        {{ ucwords($post->channel->name) }}
                    </h4>
                </div>

                <div class="d-flex">
                    <h4>
                        <avatar username="{{ $post->user->name }}"
                                avatar_path="{{ $post->user->avatar_path }}"></avatar>
                        <span>
                            <a href="{{ route('profile', $post->user) }}">
                                {{ $post->user->name }}
                            </a>
                        </span>
                        @include('layouts._follow-button', $user = $post->user)
                    </h4>

                    <span class="ml-auto mr-3">
                        <small class="text-muted">visits:</small> {{ $post->visits }}
                    </span>
                    @auth
                        <like-button
                                add-classes="h-25"
                                path="{{ $post->path() }}"
                                likes-count="{{ $post->likes_count }}"
                                :is-liked="{{ json_encode($post->isLiked) }}">
                        </like-button>
                    @endauth

                    @can('update', $post)

                        <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-primary h-25 ml-3">Edit</a>

                    @endcan

                </div>
                <br>
                @if($post->banner_path != null)
                    <div>
                        <img src="/{{ $post->banner_path }}" class="rounded">
                    </div>
                @endif
                <div class="mt-4">
                    {{--<p>{{ $post->lede }}</p>--}}
                    <div class="trix-content">{!! $post->body !!}</div>
                </div>

            </div>
            <br>
            <br>
            <div class="col-md-10">
                @auth
                    <comments @added="commentsCount++" @removed="commentsCount--"></comments>
                @endauth
            </div>
        </div>
    </post-show>

@endsection