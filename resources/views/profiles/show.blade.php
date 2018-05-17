@extends('layouts.blog')

@section('header')
    <link href="{{ asset('css/vendor/trix.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Profile</h1>
                <hr>
                <div class="d-flex">
                    <h2>{{ $profileUser->name }}</h2>

                    <span class="align-self-center ml-2 mb-1">
                        @include('layouts._follow-button', $user = $profileUser)
                    </span>

                    <span class="ml-auto">
                        <small class="text-muted">followers: {{ $profileUser->follows_count }}</small>
                        @auth
                            <like-button
                                    path="{{ $profileUser->path }}"
                                    likes-count="{{ $profileUser->liked_count }}"
                                    :is-liked="{{ json_encode($profileUser->isLiked) }}">
                            </like-button>
                        @endauth
                    </span>
                </div>

                <p class="text-muted">Member Since: {{ $profileUser->created_at->diffForHumans() }}</p>

                @can('update', $profileUser)
                    <avatar-form with-link="no" username="{{ $profileUser->name }}"
                                 avatar_path="{{ $profileUser->avatar_path }}"></avatar-form>
                @else
                    <avatar with-link="no" username="{{ $profileUser->name }}"
                            avatar_path="{{ $profileUser->avatar_path }}"></avatar>
                @endcan

            </div>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-10">
                @forelse($activities as $date => $activity)
                    <br>
                    <h4>
                        {{ $date }}
                    </h4>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>No activity for this user yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
