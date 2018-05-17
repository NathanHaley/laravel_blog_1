@component('profiles.activities.activity')
    @slot('heading')
        <strong>Published</strong>
        <i><a href="{{ $activity->subject->path() }}/show">
            {{ $activity->subject->title }}
        </a></i>
    @endslot
    @slot('body')
        {{ $activity->subject->lede }}
    @endslot
@endcomponent