<header class="blog-header py-3">
    @if(Auth::check() && Auth::user()->confirmed == false)
        <div class="alert alert-warning" role="alert">
            <strong><i class="fa fa-exclamation fa-2x mr-2"></i></strong> You still need to <strong>verify your email</strong> to participate (e.g. use likes). Please check you email for our verification message.
        </div>
    @endif
    <div class="row justify-content-between align-items-center">
        <div class="col-sm-4 pt-1">
            {{--<a class="text-muted" href="#">Subscribe</a>--}}
        </div>
        <div class="col-sm-4 text-center">
            <a class="blog-header-logo text-dark" href="{{ url('/') }}">{{ config('app.name') }}</a>
        </div>
        <div class="col-sm-4 text-center text-lg-right">
            {{--<a class="text-muted" href="#">--}}
            {{--<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>--}}
            {{--</a>--}}
            @guest
                <a class="btn btn-sm btn-outline-secondary mr-3" href="{{ route('login') }}">Login</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('register') }}">Register</a>
            @endguest
        </div>
    </div>
</header>
@include('layouts._nav')

