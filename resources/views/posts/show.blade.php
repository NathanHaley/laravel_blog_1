@extends('layouts.blog')

@section('header')
    <link href="{{ asset('css/vendor/trix.css') }}" rel="stylesheet">
    @include('posts._post-styles')
@endsection

@section('content')
    <post-show :post="{{ $post }}" inline-template>
        <div class="container">
            <div class="col-md-12">

                <div class="text-center">
                    <h1 class="h1">
                        {{ $post->title }}
                    </h1>
                    <span class="h4" style="color: {{ $post->channel->color }};">
                        {{ ucwords($post->channel->name) }}
                    </span>
                </div>

                <div class="d-flex">
                    <span class="h4">
                        <avatar username="{{ $post->user->name }}"
                                avatar_path="{{ $post->user->avatar_path }}"></avatar>
                        <span>
                            <a href="{{ route('profile', $post->user) }}">
                                {{ $post->user->name }}
                            </a>
                            <small class="h6w text-muted"> {{ $post->created_at->diffForHumans() }}</small>
                        </span>
                        @include('layouts._follow-button', $user = $post->user)
                    </span>

                    <span class="ml-auto mr-3 text-center">
                        <small class="text-muted">visits</small><br>{{ $post->visits }}
                    </span>

                    <span class="rounded-circle text-nowrap p-2">
                        <i class="fa fa-comment"></i>
                        {{ $post->comments_count }}
                    </span>

                    <like-button
                            add-classes="h-25"
                            path="{{ $post->path() }}"
                            likes-count="{{ $post->likes_count }}"
                            :is-liked="{{ json_encode($post->isLiked) }}">
                    </like-button>


                    @can('update', $post)
                        <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-primary h-25 ml-3">Edit</a>
                    @endcan
                    @can('delete', $post)
                        <a href="{{ route('post.delete', $post) }}" class="btn btn-outline-danger h-25 ml-3">Delete</a>
                    @endcan

                </div>
                <br>

                @if($post->banner_path != null)
                    <div class="rounded h-250 post_banner"></div>
                @endif
                <div class="mt-4">
                    <div class="trix-content">{!! $post->body !!}</div>
                </div>

            </div>
            <br>
            <br>
            <div class="col-md-10">
                <comments path="{{ $post->path() }}" @added="commentsCount++" @removed="commentsCount--"></comments>
            </div>
        </div>
    </post-show>

@endsection