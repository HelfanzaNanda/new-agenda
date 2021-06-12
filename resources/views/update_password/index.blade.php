@extends('layouts.app', [
	'title' => 'Update Password'
])
@section('content')
<div class="row justify-content-center align-items-center">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">Update Password</div>
		
			<div class="card-body">
				<form method="POST" action="#" class="mx-4" id="form-update-password">
					@csrf
		
					<div class="form-group">
						<label for="password">{{ __('Password') }}</label>
						<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
						 name="password" required >
						<x-validation-error id="error-password"/>
					</div>
		
					<div class="form-group">
						<label for="password">Konfirmasi Password</label>
						<input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
					</div>
		
					<div class="form-group d-flex justify-content-end mb-0">
						<button type="button" class="btn btn-primary" onclick="updatePassword(event)">
							Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
	<script>
		const updatePassword = async (e) => {
			setLoading(e)
			
			let form = new FormData($('#form-update-password')[0]);
			let url = "{{ route('update.password') }}"
			
			try {
				const response = await axios.post(url, form)
				hideLoading(e, "Update")
				resetForm()
				toastr["success"](response.data.message, "success")
			} catch (error) {
				hideLoading(e, "Update")
				const errors = error.response.data.errors
				Object.keys(errors).map(field => $('#error-'+field).text(errors[field][0]))
			}
		}

		const resetForm = () => {
			$('#password').val('')
			$('#password_confirmation').val('')
		}
	</script>
@endpush