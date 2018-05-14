<div class="card mt-5">
    <div class="card-body post-card">
        @if(isset($show_avatar) && $show_avatar  === true)
            <avatar classes="post-card-avatar" username="{{ $post->user->name }}" avatar_path="{{ $post->user->avatar_path }}" width="4"></avatar>
        @endif
        <h5 class="card-title d-flex pt-3">
            <span>
                <a style="color: black;" href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
            </span>
            <span class="ml-auto">
                <small class="text-muted">visits:</small> {{ $post->visits }}
            </span>
        </h5>
            <h5><a href="{{ route('channel.posts', $post->channel) }}" style="color: {{ $post->channel->color }}">{{ $post->channel->name }}</a></h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->format('n-d-Y') }}</h6>
        <p class="card-text">{{ $post->lede }}</p>
        <a href="{{ route('post.show', $post) }}" class="card-link">Read more...</a>
    </div>
    @can('update', $post)
        <div class="card-footer">
            <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-primary btn-sm">Edit</a>
            @can('delete', $post)
                <a href="{{ route('post.delete', $post) }}" class="btn btn-outline-danger btn-sm">Delete</a>
            @endcan
        </div>
    @endcan
</div>