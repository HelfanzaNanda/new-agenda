<div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-user">
				@csrf
				<input type="hidden" name="id" id="input-id">
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Nama</label>
						<input type="text" name="name" id="input-name" class="form-control">
						<x-validation-error id="error-name"/>
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="email" id="input-email" class="form-control">
						<x-validation-error id="error-email"/>
					</div>

					<div class="form-group">
						<label for="role">Role</label>
						<select name="role" id="input-role" class="form-control">
							<option value="" selected disabled>Pilih Role</option>
							@foreach ($roles as $role)
								<option value="{{ $role->name }}">{{ $role->name }}</option>
							@endforeach
						</select>
						<x-validation-error id="error-role"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn-save btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>