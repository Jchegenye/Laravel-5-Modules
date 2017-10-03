@component('mail::message')
# Welcome {{$user->name}}

Thanks for signing up. **We really appriciate** it. Let us _know if we can_ do more to please you.

@component('mail::panel')
	The email address you signed up with is {{$user->email}}
@endcomponent

@component('mail::button', ['url' => 'http://laravel5modules.dev/home'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent