@section('header')
    <link href="{{ asset('css/vendor/trix.css') }}" rel="stylesheet">
@endsection

<div class="card" v-if="editing" v-cloak>
    <div class="card-header">
        <div class="level">
            <div class="form-group flex">
                <input type="text" name="title" class="form-control" v-model="form.title">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <wysiwyg name="body" v-model="form.body"></wysiwyg>
        </div>
    </div>
    <div class="card-footer">
        <div class="level">
            <button class="btn btn-sm btn-primary" @click="update">Update</button>
            <button class="btn btn-sm btn-link" @click="resetForm">Cancel</button>
            @can('update', $post)
                <form action="{{ $post->path() }}" method="POST" class="ml-auto">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete Post</button>
                </form>
            @endcan
        </div>

    </div>
</div>

<div class="card" v-else v-cloak>
    <div class="card-header">
        <div class="level">
            <img class="mr-3" src="{{ asset($post->owner->avatar_path) }}" width="30" height="30"
                 alt="{{ $post->owner->name }}">
            <span class="flex">
                <a href="{{ route('profile', $post->owner) }}">
                    {{ $post->owner->name }}
                </a>
                posted: <span v-text="title"></span>
                <p class="text-muted">{{ $post->created_at->diffForHumans() }}...</p>
            </span>
        </div>
    </div>
    <div class="card-body trix-content" v-html="body"></div>
    @can('update', $post)
        <div class="card-footer">
            <button class="btn btn-sm btn-primary mr-1" @click="editing = true">Edit</button>
        </div>
    @endcan
</div>