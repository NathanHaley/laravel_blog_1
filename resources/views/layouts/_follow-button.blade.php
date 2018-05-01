@if(auth()->check() && auth()->user()->id != $user->id)
        <follow-button :active="{{ json_encode(auth()->user()->isFollowing($user->id)) }}"
                       user-id="{{ $user->name }}"></follow-button>
@endif