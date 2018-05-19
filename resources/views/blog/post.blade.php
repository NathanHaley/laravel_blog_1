<div class="blog-post">
    <span class="d-flex">
        <a style="color: black" href="{{ route('post.show', $post) }}">
            <h2 class="blog-post-title">{{ $post->title }}</h2>
        </a>
        <span class="ml-auto">
            @auth
                <like-button

                        path="{{ $post->path() }}"
                        likes-count="{{ $post->likes_count }}"
                        :is-liked="{{ json_encode($post->isLiked) }}">
                </like-button>
                @else
                <like-button
                        add-classes="disabled"
                        :logged-in="false"
                        path="{{ $post->path() }}"
                        likes-count="{{ $post->likes_count }}"
                        :is-liked="{{ json_encode($post->isLiked) }}">
                </like-button>
            @endauth
            @can('update', $post)
                <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-primary btn-xs">Edit</a>
            @endcan
        </span>
    </span>
    <p class="blog-post-meta">
        <small>{{ $post->created_at->diffForHumans() }} by</small>
        <a href="profiles/{{ $post->user->name }}">{{ $post->user->name }}</a>
        <avatar username="{{ $post->user->name }}" avatar_path="{{ $post->user->avatar_path }}"></avatar>
    </p>
    @if($post->banner_path != null)
        <div class="rounded h-250 mb-3"
             style="background: url('{{ $post->banner_path }}'); background-position: center center; background-repeat: no-repeat;"></div>
    @endif
    <p>{{ $post->lede }}</p>
    <p><a href="{{ route('post.show', $post) }}">read more...</a></p>
</div><!-- /.blog-post -->

