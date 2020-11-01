@component('mail::message')
# Congrats {{ $admin->name }}

<p>
    You have been registered as a {{$admin->company->company_name}} admin. Kindly use <b> {{ $password }} </b>  to login
</p>

@component('mail::button', ['url' => 'martek-admin.herokuapp.com'])
    login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
