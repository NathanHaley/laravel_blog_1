@foreach($post->comments as $comment)
    <div class="card mt-5">
        <div class="card-header">
            <avatar username="{{ $comment->user->name }}" avatar_path="{{ $comment->user->avatar_path }}"></avatar>
            <span>
            {{ $comment->user->name }}
        </span>
            <span class="ml-auto text-muted">
            {{ $post->created_at->diffForHumans() }}
        </span>
        </div>
        <div class="card-body">
            <p class="card-text">{{ $comment->body }}</p>
        </div>
        {{--@if($comment->user->id == auth()->id() || auth()->user()->isAdmin())--}}
            @can('update', $comment)
            <div class="card-footer d-flex">
                <span>
                    <form method="POST"
                          action="{{ route('comment.update', $comment) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary">Update</button>
                    </form>
                </span>
                <span class="ml-3">
                    <form method="POST"
                          action="{{ route('comment.destroy', $comment) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                    </form>
                </span>
            </div>
        {{--@endif--}}

        {{--<div class="card-footer">hi</div>--}}
        @endcan
    </div>
@endforeach

