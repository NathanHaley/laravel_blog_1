<div class="card mt-5">
    @auth
        <div class="card-header"></div>
    @endauth
        <div class="card-body">
            <h5 class="card-title d-flex">
                <span>
                    {{ $post->title }}
                </span>
                <span class="ml-auto">
                    <small class="text-muted">visits:</small> {{ $post->visits }}
                </span>
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->format('n-d-Y') }}</h6>
            <p class="card-text">{{ $post->lede }}</p>
            <a href="{{ route('post.show', $post) }}" class="card-link">Read more...</a>
        </div>
    @can('update', $post)
        <div class="card-footer">
            <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-primary btn-sm">Edit</a>
        </div>
    @endcan
</div>