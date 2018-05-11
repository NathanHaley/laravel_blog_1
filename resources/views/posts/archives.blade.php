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
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="d-flex h1">
                    Post Archives: {{ $monthName }} {{ $year }}
                </div>
                <hr>
                @foreach($posts as $post)

                    @include('posts._card', ['show_avatar' => true])

                @endforeach
            </div>
            <aside class="blog-sidebar ml-auto">
                @include('posts.archives-menu')
            </aside>
        </div>
    </div>
@endsection