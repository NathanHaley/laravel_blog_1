@section('header')
    <style type="text/css">
        #jumbotron-feature {
            background: linear-gradient(
                    to right,
                    rgba(0, 0, 0, .6),
                    rgba(0, 0, 0, .2),
                    rgba(0, 0, 0, 0),
                    rgba(0, 0, 0, 0)),
            url({{ $banner->banner_path }});;
            background-size: cover;
            text-shadow: 2px 2px #000;
        }
    </style>
@endsection


<div id="jumbotron-feature" class="jumbotron p-3 p-md-5 text-white rounded bg-dark" style="">
    <div class="col-md-6 px-0">
        <h1 class="display-4 font-italic">{{ $banner->title }}</h1>
        <p class="lead my-3">{{ $banner->lede }}</p>
        <p class="lead mb-0"><a href="{{ route('post.show', $banner) }}" class="text-white font-weight-bold">Continue reading...</a></p>
    </div>
</div>
