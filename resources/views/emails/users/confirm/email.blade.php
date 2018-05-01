@component('mail::message')
    # One last step

    We just need you to confirm your email address to prove you are human. You get it, right? Cool.

    @component('mail::button', ['url' => url('/register/confirm?token='.$user->confirmation_token)])
        Confirm Email
    @endcomponent

    Thanks,<br>
    Nathan Haley
@endcomponent
