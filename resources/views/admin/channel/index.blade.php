@extends('layouts.blog')

@section('content')
    <h1>Channel List</h1>
    <p class="text-muted">(Alphabetical)</p>
    <hr>
    <div class="col-md-10">
        @include('admin.channel.form.small.create')
        <table class="table">
            <thead>
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
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($channels as $channel)
                <tr>
                    <td scope="row">
                        <div class="border border-dark rounded-circle" style="
                                width: 25px;
                                height: 25px;
                                background-color: {{ $channel->color }};
                                color: {{ (hexdec($channel->color) > (hexdec('#ffffff')/2)) ? 'black':'white' }};">
                            &nbsp;
                        </div>
                        {{ $channel->color }}
                    </td>
                    <td><a href="{{ route('admin.channel.edit', $channel->slug) }}">{{ $channel->name }}</a></td>
                    <td>{{$channel->description}}</td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm" href="channel/{{ $channel->slug }}/edit">Edit</a>
                    </td>
                    <td>
                        @if($channel->trashed())
                            <form name="channel-{{ $channel->id }}"
                                  id="channel-{{ $channel->id }}"
                                  method="POST"
                                  action="{{ route('admin.archive-channel.store', $channel->slug) }}">
                                @csrf
                                <input type="hidden" name="slug" value="{{ $channel->slug }}">
                                <button class="btn btn-dark btn-sm" type="submit">Un-Archive</button>
                            </form>
                        @else
                            <form name="channel-{{ $channel->id }}"
                                  id="channel-{{ $channel->id }}"
                                  method="POST"
                                  action="{{ route('admin.archive-channel.destroy', $channel->slug) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-dark btn-sm" type="submit">&nbsp;&nbsp;&nbsp;Archive&nbsp;&nbsp;&nbsp;</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection