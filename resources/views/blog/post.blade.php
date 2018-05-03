<div class="blog-post">
    <h2 class="blog-post-title d-flex">
        <span>
           <a href="{{ route('post.show', $post->slug) }}">
                {{ $post->title }}
           </a>
        </span>
        <span class="ml-auto">
             @can('update', $post)
                <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-primary btn-xs">Edit</a>
            @endcan
        </span>
    </h2>
    <p class="blog-post-meta">
        <avatar username="{{ $post->user->name }}" avatar_path="{{ $post->user->avatar_path }}"></avatar>
        <a href="profiles/{{ $post->user->name }}">{{ $post->user->name }}</a>
        <small>{{ $post->created_at->diffForHumans() }}</small>
    </p>

    <p>{{ $post->lede }}</p>
    <a href="{{ route('post.show', $post) }}" class="card-link">Read more...</a>
    <hr>

</div><!-- /.blog-post -->

