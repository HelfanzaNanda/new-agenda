@component('mail::message')

# Halo {{ $email }}
klik link berikut untuk reset password

@component('mail::button', [
	'url' => route('user.password.reset', [
		$email, $token
	])
])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
