@section('header')
    <style type="text/css">
        #jumbotron-feature {
            position: relative;
            background: linear-gradient(
                    to right,
                    rgba(0, 0, 0, .6),
                    rgba(0, 0, 0, .2),
                    rgba(0, 0, 0, 0),
                    rgba(0, 0, 0, 0)),
            url({{ $banner->banner_path }});
            background-size: cover;
            background-repeat: no-repeat;
            text-shadow: 2px 2px #000;
        }

        #jumbotron-feature-avatar {
            position: absolute;
            top: -0.9em;
            right: -0.8em;
            border: 1px solid white;

        }

        .featured-card {
            position: relative;
        }

        .featured-card-avatar {
            position: absolute;
            top: -0.3em;
            right: 0.3em;
            border: 1px solid white;
            z-index: 2;
        }
    </style>
@endsection


<div id="jumbotron-feature" class="jumbotron p-3 p-md-5 text-white rounded bg-dark" style="">
    <avatar id="jumbotron-feature-avatar" username="{{ $banner->user->name }}" avatar_path="{{ $banner->user->avatar_path }}" width="6" ></avatar>
    <div class="col-md-6 px-0">
        <h1 class="display-4 font-italic">{{ $banner->title }}</h1>
        <p class="lead my-3">{{ $banner->lede }}</p>
        <p class="lead mb-0"><a href="{{ route('post.show', $banner) }}" class="text-white font-weight-bold">Continue reading...</a></p>
    </div>
</div>
