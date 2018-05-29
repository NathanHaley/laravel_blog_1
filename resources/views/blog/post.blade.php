<div class="container blog-post m-0 p-0">
    <div class="row flex-nowrap">
        <div class="col-sm-10" style="overflow: hidden;">
            <span class="" >
                <a style="color: black" href="{{ route('post.show', $post) }}">
                    <h2 class="blog-post-title">{{ $post->title }}</h2>
                </a>
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
        </div>
        <div class="col m-1">
            <div class="bg-light p-1 text-center rounded bg-light m-0">
                <div class="text-nowrap">
                    <small class="text-muted">visits</small> {{ $post->visits }}
                </div>
                <div class="rounded-circle text-nowrap p-2">
                    <i class="fa fa-comment"></i>
                    {{ $post->comments_count }}
                </div>
                <div>
                    <like-button
                            path="{{ $post->path() }}"
                            likes-count="{{ $post->likes_count }}"
                            :is-liked="{{ json_encode($post->isLiked) }}">
                    </like-button>
                </div>
                @can('update', $post)
                    <div>
                        <a href="{{ route('post.edit', $post) }}" class="btn btn-outline-primary btn-xs">Edit</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>

</div><!-- /.blog-post -->

