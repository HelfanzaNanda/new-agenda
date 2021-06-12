@extends('layouts.auth')
@section('content')
<div class="card">
	<div class="card-header">{{ __('Login') }}</div>

	<div class="card-body">
		@if (session('status'))
			<div class="alert alert-success" role="alert">
				{{ session('status') }}
			</div>
		@endif
		<form method="POST" action="{{ route('login') }}" class="mx-4">
			@csrf

			<div class="form-group">
				<label for="email">{{ __('E-Mail Address') }}</label>
				<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
				@error('email')
					<span class="text-danger text-xs mt-2" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="password">{{ __('Password') }}</label>
				<input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">

				@error('password')
					<span class="text-danger text-xs mt-2" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="form-group d-flex justify-content-between">
				<div class="form-check d-flex align-items-center">
					<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
					<label class="form-check-label" for="remember">
						{{ __('Remember Me') }}
					</label>
				</div>
				<a class="btn btn-link" href="{{ route('user.password.request') }}">
					{{ __('Forgot Your Password?') }}
				</a>
			</div>

			<div class="form-group d-flex justify-content-end mb-0">
				<button type="submit" class="btn btn-primary">
					{{ __('Login') }}
				</button>
			</div>
		</form>
	</div>
</div>
@endsection