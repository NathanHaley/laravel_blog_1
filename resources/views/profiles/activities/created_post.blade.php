@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} published:
        <a href="{{ $activity->subject->path() }}/show">
            {{ $activity->subject->title }}
        </a>
    @endslot
    @slot('body')
        {{ $activity->subject->lede }}
    @endslot
@endcomponent