@extends('layouts.blog')

@section('content')

    @include('blog.jumbotron')

    @include('blog.featured')

    <main role="main" class="container">
        <div class="row">

            @include('blog.main')

            @include('blog.sidebar')

        </div><!-- /.row -->

    </main><!-- /.container -->

@endsection