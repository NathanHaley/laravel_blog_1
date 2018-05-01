<form method="POST" action="{{ route('admin.channel.store') }}">
    @csrf
    <table class="table">
        <thead>
        <tr>
            <th scope="col" colspan="4" class="text-center">Add A Channel</th>
        </tr>
        <tr>
            <th scope="col">
                Color
            </th>
            <th scope="col">
                Name
            </th>
            <th scope="col">
                Description
            </th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td scope="row">
                <input name="color"
                       id="color"
                       type="text"
                       class="form-control form-control-sm"
                       placeholder="Ex. #e6e6e6..."
                       value="{{ old('color') }}"
                       required>
            </td>
            <td>
                <input name="name"
                       type="text"
                       id="name"
                       class="form-control form-control-sm"
                       placeholder="Brief name..."
                       value="{{ old('name') }}"
                       required>
            </td>
            <td>
                <textarea name="description"
                          id="description"
                          class="form-control"
                          rows="3"
                          placeholder="A little description is always helpful..."
                          required>{{ old('description') }}</textarea>
            </td>
            <td>
                <button class="btn btn-sm btn-outline-dark btn-sm" type="submit">Add</button>
            </td>
        </tr>
        </tbody>
    </table>
</form>
@include('layouts._errors')