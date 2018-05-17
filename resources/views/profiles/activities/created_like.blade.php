@component('profiles.activities.activity')
    @slot('heading')

        <strong>Liked</strong>
        @switch($activity->subject->liked_type)
            @case(\App\User::class)
                the member <a href="{{ route('profile', $activity->subject->liked) }}">
                    {{ $activity->subject->liked->name }}
                </a>

            @break
            @case(\App\Post::class)
                the article titled
                <i>
                    <a href="{{ route('post.show', $activity->subject->liked) }}">
                        {{ $activity->subject->liked->title }}
                    </a>
                </i>
                written by
                <a href="{{ route('profile', $activity->subject->liked->user) }}">
                    {{ $activity->subject->liked->user->name }}
                </a>

            @break
            @case(\App\Comment::class)
                a comment by
                <a href="{{ route('profile', $activity->subject->liked->user) }}">
                    {{ $activity->subject->liked->user->name }}
                </a>
                on article
                <i>
                    <a href="{{ route('post.show', $activity->subject->liked->post) }}">{{ $activity->subject->liked->post->title }}</a>
                </i>
                written by
                <a href="{{ route('profile', $activity->subject->liked->post->user) }}">
                    {{ $activity->subject->liked->post->user->name}}
                </a>

            @break
        @endswitch
    @endslot
    {{--@slot('body')@endslot--}}
@endcomponent