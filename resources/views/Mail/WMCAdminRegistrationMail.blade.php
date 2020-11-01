@component('mail::message')
# Welcome {{ $admin->name }} <br>

You have successfully registered with Wipapp-Gh. Kindly click on the button to verify your email

@component('mail::button', ['url' => "wipapp.herokuapp.com/auth/email/verify?token={$token->token}"])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
