@component('mail::message')
# Hello {{ $username }}

Thank you for your registration on Group Up. Activate your account by clicking on the button below and start playing with your friends!

@component('mail::button', ['url' => $url])
Activate my account
@endcomponent

See you in game,<br>
The {{ config('app.name') }} team
@endcomponent
