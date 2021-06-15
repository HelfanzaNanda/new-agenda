@extends('layouts.app')

@section('content')
<div class="app-page-title">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
				</i>
			</div>
			<div>Agenda
				{{-- <div class="page-title-subheading">Tables are the backbone of almost all web applications.
				</div> --}}
			</div>
		</div>
		<div class="page-title-actions">
			<button type="button" class="btn-add btn-shadow mr-3 btn btn-primary">
				Tambah Agenda
			</button>
		</div>    
	</div>
</div>            
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				@include('components.datatables-default',[
					'url' => route('agenda.datatables'),
					'columns'=> [
						'h/t'	=> '<th>H/T</th>',
						'name'	=> '<th >Kegiatan</th>',
						'executor'	=> '<th>Pelaksana Kegiatan</th>',
						'time'	=> '<th>Jam</th>',
						'place'	=> '<th>Tempat</th>',
						'_buttons'=> '<th>Action</th>',
					],
				])
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('agenda.modal')
@endsection

@push('scripts')
	<script>
		$(document).ready(function () {  
			$('.daterange').daterangepicker({
				minDate: new Date()
			});
			$('.timepicker').timepicker({
				timeFormat: 'HH:mm',
				interval: 60,
				minTime: '08:00',
				maxTime: '16:00',
				defaultTime: '08:00',
				startTime: '08:00',
				dynamic: false,
				dropdown: true,
				scrollbar: true
			});
		})


		$(document).on('click', '.btn-add', function (e) {  
			e.preventDefault()
			resetForm()
			resetError()
			$('.modal-title').text('Tambah Agenda')
			$('#modal-agenda').modal('show')
		})

		$(document).on('change', '#check-end-time', function (e) {  
			e.preventDefault()
			const isChecked =$(this).is(':checked')
			if(isChecked){
				$('#input-end-time').val('Selesai')
				$('#input-end-time').attr('readonly', 'readonly');
			}else{
				$('#input-end-time').val('')
				$('#input-end-time').removeAttr('readonly');
			}
		})

		const resetForm = () => {
			$('#input-id').val('')
			$('#input-date-range').val('')
			$('#input-start-time').val('')
			$('#input-end-time').val('')
			$('#input-name').val('')
			$('#input-place').val('')
			$('#input-executor').val('')
			$('#input-file').val('')
		}

		const resetError = () => {
			$('#error-date_range').val('')
			$('#error-start_time').val('')
			$('#error-end_time').val('')
			$('#error-name').val('')
			$('#error-place').val('')
			$('#error-executor').val('')
			$('#error-file').val('')
		}

		$(document).on('click', '.btn-edit', async function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url = "{{ route('agenda.get', '') }}"+"/"+id
			resetError()
			try {
				const response = await axios.get(url)
				$('#input-id').val(response.data.id)
				$('#input-date-range').daterangepicker('setDate', response.data.daterange)
				$('#input-start-time').val(response.data.start_time)
				if(response.data.end_time === 'Selesai'){
					$('#input-end-time').attr('readonly', 'readonly')
					$('#check-end-time').prop('checked', true);
				}else{
					$('#input-end-time').removeAttr('readonly')
					$('#check-end-time').prop('checked', false)
				}
				$('#input-end-time').val(response.data.end_time)
				$('#input-name').val(response.data.name)
				$('#input-place').val(response.data.place)
				$('#input-executor').val(response.data.executor)
				$('.modal-title').text('Edit Agenda')
				$('#modal-agenda').modal('show')
			} catch (error) {
				console.log(error);
			}
		})

		$(document).on('click', '.btn-delete', function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url = "{{ route('agenda.delete', '') }}"+"/"+id
			deleteData(url, null, true)
		})

		$(document).on('click', '.btn-save', async function (e) {  
			e.preventDefault()
			setLoading(e)
			const form = new FormData( $('#form-agenda')[0] )
			const url = "{{ route('agenda.createorupdate') }}"
			try {
				const response = await axios.post(url, form)
				resetForm()
				hideLoading(e, "Save")
				$('#modal-agenda').modal('hide')
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