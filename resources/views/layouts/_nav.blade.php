<nav class="navbar navbar-expand-md navbar-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name') }}
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @auth
                <ul class="navbar-nav">
                    <li><a class="nav-link" href="{{route('post.create')}}">Create Post</a></li>
                </ul>
            @endauth

            <ul class="navbar-nav">
                @foreach($channels as $channel)
                    <li><a class="nav-link" style="color: {{ $channel->color }}" href="{{ route('channel.posts', $channel) }}">{{ $channel->name }}</a></li>
                @endforeach
            </ul>

            @can('view', auth()->user(), \App\Channel::class)
                <ul class="navbar-nav">
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
                </ul>
        @endcan
            <ul class="navbar-nav">
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
                    <user-notifications></user-notifications>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <avatar with-link="no" id="nav_avatar" username="{{ auth()->user()->name }}"
                                    avatar_path="{{ auth()->user()->avatar_path }}"></avatar>
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