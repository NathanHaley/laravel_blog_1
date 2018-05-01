@include('layouts._header')

<div id="app" class="container">

@include('blog.header')

@yield('content')

    <flash message="{{ session('flash')['message'] ?? session('flash') }}" type="{{ session('flash')['type'] ?? 'success' }}"></flash>
</div>
@include('layouts._footer')

