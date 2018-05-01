@extends('layouts.blog')

@section('content')
    <h1>Add Channel</h1>
    <hr>

    <form method="POST" action="{{ route('admin.channel.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input name="name" type="text" class="form-control" id="name"
                   placeholder="Brief name..."
                   value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input name="color" type="text" class="form-control" id="color"
                   placeholder="Hex color value, like #e6e6e6..."
                   value="{{ old('color') }}" required>
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="description" class="form-control" id="description" rows="3"
                      placeholder="A little description is always helpful..."
                      required>{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Channel</button>
        </div>
    </form>

    @include('layouts._errors')


@endsection