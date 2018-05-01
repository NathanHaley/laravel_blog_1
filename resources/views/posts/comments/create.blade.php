<form method="POST" action="{{ route('comment.create', $post) }}">
    @csrf
    <div class="form-group">
            <textarea name="body" class="form-control" id="body" rows="3"
                      placeholder="Got a comment?"
                      required>{{ old('body') }}</textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Comment</button>
    </div>
</form>
