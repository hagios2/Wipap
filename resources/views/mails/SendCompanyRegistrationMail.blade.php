@component('mail::message')
# Congrats {{ $company->company_name }}, <br>

<p>You have successfully resgistered on Wipap platform.</p>
{{-- 
@component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
