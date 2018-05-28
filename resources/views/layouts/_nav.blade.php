<nav class="navbar navbar-expand-lg navbar-light mb-2">
    <div class="container">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav">
                @auth
                    <li><a class="nav-link" href="{{route('post.create')}}">Create Post</a></li>
                @endauth

                @foreach($channels as $channel)
                    <li><a class="nav-link" style="color: {{ $channel->color }}"
                           href="{{ route('channel.posts', $channel) }}">{{ $channel->name }}</a></li>
                @endforeach

                @can('view', auth()->user(), \App\Channel::class)
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown1" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Channels <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <a class="dropdown-item" href="{{ route('admin.channel.index') }}">List</a>
                            <a class="dropdown-item" href="{{ route('admin.channel.create') }}">Create</a>
                        </div>
                    </li>
                @endcan

                <li class="nav-item dropdown">
                    <a id="navbarDropdown2" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Authors <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                        @foreach($authors as $author)
                            <a class="dropdown-item" href="{{ route('profile', $author) }}">
                                <avatar with-link="no" id="avatar-{{ $author->id }}" username="{{ $author->name }}"
                                        avatar_path="{{ $author->avatar_path }}"></avatar>
                                {{ $author->name }}
                            </a>
                        @endforeach
                    </div>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @auth
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <button id="nav_notifications" data-toggle="collapse" data-target="#demo" class="btn btn-link nav-item nav-link">
                            <span class="nav-link">
                                <i class="fa fa-exclamation-circle"></i>
                                Notifications
                                <span class="caret"></span>
                            </span>
                        </button>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar_path }}"
                                 id="nav_avatar"
                                 class="relative rounded-circle"
                                 style="width: 2em;">
                            <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('user-posts', auth()->user()) }}">
                                My Posts
                            </a>
                            <a class="dropdown-item" href="{{ route('profile', auth()->user()) }}">
                                My Profile
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
@if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)<user-notifications></user-notifications>@endif