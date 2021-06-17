@extends('layouts.app')

@section('content')
<div class="app-page-title" style="margin-bottom: 0">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="metismenu-icon fas fa-users icon-gradient bg-happy-itmeo">
				</i>
			</div>
			<div>Users
				{{-- <div class="page-title-subheading">Tables are the backbone of almost all web applications.
				</div> --}}
			</div>
		</div>
		<div class="page-title-actions">
			<button type="button" class="btn-add btn-shadow mr-3 btn btn-primary">
				Tambah User
			</button>
		</div>    
	</div>
</div>            
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				@include('components.datatables-default',[
					'url' => route('user.datatables'),
					'columns'=> [
						'name'	=> '<th>Nama</th>',
						'email'	=> '<th>Email</th>',
						'_buttons'=> '<th>Action</th>'
					],
				])
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('user.modal')
@endsection

@push('scripts')
	<script>
		$(document).on('click', '.btn-add', function (e) {  
			e.preventDefault()
			resetForm()
			resetError()
			$('.modal-title').text('Tambah User')
			$('#modal-user').modal('show')
		})

		const resetForm = () => {
			$('#input-id').val('')
			$('#input-name').val('')
			$('#input-email').val('')
			$('#input-role').val('').trigger('change')
		}

		const resetError = () => {
			$('#error-name').text('')
			$('#error-email').text('')
			$('#error-role').text('')
		}

		$(document).on('click', '.btn-edit', async function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url = "{{ route('user.get', '') }}"+"/"+id
			resetError()
			try {
				const response = await axios.get(url)
				$('#input-id').val(response.data.user.id)
				$('#input-name').val(response.data.user.name)
				$('#input-email').val(response.data.user.email)
				$('#input-role').val(...response.data.role).trigger('change')
				$('.modal-title').text('Edit User')
				$('#modal-user').modal('show')
			} catch (error) {
				console.log(error);
			}
		})

		$(document).on('click', '.btn-delete', function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url = "{{ route('user.delete', '') }}"+"/"+id
			deleteData(url, null, true)
		})

		$(document).on('click', '.btn-save', async function (e) {  
			e.preventDefault()
			setLoading(e)
			const form = new FormData( $('#form-user')[0] )
			const url = "{{ route('user.createorupdate') }}"
			try {
				const response = await axios.post(url, form)
				resetForm()
				hideLoading(e, "Save")
				$('#modal-user').modal('hide')
				$('#datatable').DataTable().ajax.reload()
				toastr["success"](response.data.message, "success")
			} catch (error) {
				hideLoading(e, "Save")
				if(error.response.status === 422){
					const errors = error.response.data.errors
					Object.keys(errors).map(field => $('#error-'+field).text(errors[field][0]))	
				}	
			}
		})
	</script>
@endpush