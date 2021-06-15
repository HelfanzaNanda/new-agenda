@extends('layouts.app')

@section('content')
<style>
	.ui-timepicker-container {
		z-index: 3500 !important;
	}
</style>
<div class="app-page-title">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
				</i>
			</div>
			<div>Edit Agenda
				{{-- <div class="page-title-subheading">Tables are the backbone of almost all web applications.
				</div> --}}
			</div>
		</div>
	</div>
</div>            
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<form id="form-agenda">
					@csrf
					<input type="hidden" name="id" id="input-id">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="date_range">Tanggal</label>
								<input type="text" name="date_range" id="input-date-range" 
								value="{{ $agenda['daterange'] }}"
								class="form-control daterange">
								<x-validation-error id="error-date_range" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="jam_mulai">Jam Mulai</label>
								<input type="text" name="jam_mulai" id="input-jam-mulai" 
								value="{{ $agenda->jam_mulai }}"
								class="form-control timepicker">
								<x-validation-error id="error-jam_mulai"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="jam_selesai">Jam Selesai</label>
								<input type="text" name="jam_selesai" id="input-jam-selesai" 
								{{ $agenda->jam_selesai ? '' : 'readonly' }}
								value="{{ $agenda->jam_selesai ?? 'Selesai' }}"
								class="form-control timepicker">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="check-jam-selesai" 
									{{ $agenda->jam_selesai ? '' : 'checked' }}>
									<label class="form-check-label" for="check-jam-selesai">
									  s.d Selesai
									</label>
								</div>
								<x-validation-error id="error-jam_selesai"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="kegiatan">Kegiatan</label>
						<input type="text" name="kegiatan" id="input-kegiatan" class="form-control"
						value="{{ old('kegiatan') ?? $agenda->kegiatan }}">
						<x-validation-error id="error-kegiatan"/>
					</div>

					<div class="form-group">
						<label for="tempat">Tempat</label>
						<input type="text" name="tempat" id="input-tempat" class="form-control"
						value="{{ old('tempat') ?? $agenda->tempat }}">
						<x-validation-error id="error-tempat"/>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="pelaksana">Pelaksana Kegiatan</label>
								<input type="text" name="pelaksana" id="input-pelaksana" class="form-control"
								value="{{ old('pelaksana') ?? $agenda->pelaksana_kegiatan }}">
								<x-validation-error id="error-pelaksana"/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="disposisi">Disposisi</label>
								<select name="disposisi" id="input-disposisi" class="form-control">
									<option value="" selected disabled>Pilih Disposisi</option>
									@foreach ($users as $user)
										<option 
										{{ $user->id == $agenda->disposisi ? 'selected' : '' }}
										value="{{ $user->id }}">{{ $user->name }}</option>
									@endforeach
								</select>
								<x-validation-error id="error-disposisi"/>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="undangan">Undangan</label>
								<input type="file" name="undangan" id="input-undangan" class="form-control">
								<x-validation-error id="error-undangan"/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="materi">Materi</label>
								<input type="file" name="materi" id="input-materi" class="form-control">
								<x-validation-error id="error-materi"/>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="absen">Daftar Hadir</label>
								<input type="file" name="absen" id="input-absen" class="form-control">
								<x-validation-error id="error-absen"/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="notulen">Notulen</label>
								<input type="file" name="notulen" id="input-notulen" class="form-control">
								<x-validation-error id="error-notulen"/>
							</div>
						</div>
					</div>
					<div class="documentations">
						<div class="d-flex justify-content-end">
							<button class="btn btn-primary btn-add-item">Tambah Dokumentasi</button>
						</div>
						<label class="block">Dokumentasi</label>
						<div class="row align-items-start">
							<div class="col-md-6">
								<div class="form-group">
									<input type="file" name="dokumentasi[]" id="input-dokumentasi-0" class="form-control">
									<x-validation-error id="error-dokumentasi[0]"/>
								</div>
							</div>
						</div>
					</div>
					<div>
						<a href="{{ route('agenda.index') }}" type="button" class="btn btn-secondary" >Close</a>
						<button type="button" class="btn-save btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
	<script>
		let indexItem = 0

		$(document).ready(function () {  
			$('.daterange').daterangepicker({
				minDate: new Date()
			});
			$('.timepicker').timepicker({
				timeFormat: 'HH:mm',
				interval: 60,
				minTime: '08:00',
				maxTime: '16:00',
				//defaultTime: '08:00',
				startTime: '08:00',
				dynamic: false,
				dropdown: true,
				scrollbar: true
			});
		})

		$(document).on('click', '.btn-add-item', function (e) {  
			e.preventDefault()
			indexItem++
			$('.documentations').append(showItem())
		})

		$(document).on('click', '.btn-remove-item', function (e) {  
			e.preventDefault()
			const key = $(this).data('key')
			$('.row-'+key).remove()
		})

		function showItem() {  
			let item = ''
				item += '<div class="row align-items-start row-'+indexItem+'">'
				item += '	<div class="col-md-6">'
				item += '		<div class="form-group">'
				item += '			<input type="file" name="dokumentasi[]" id="input-dokumentasi-'+indexItem+'" class="form-control">'
				item += '			<x-validation-error id="error-dokumentasi[0]"/>'
				item += '		</div>'
				item += '	</div>'
				item += '	<div class="col-md-6">'
				item += '		<button data-key="'+indexItem+'" class="btn btn-remove-item btn-danger ">Remove</button>'
				item += '	</div>'
				item += '</div>'
			return item;
		}

		$(document).on('change', '#check-jam-selesai', function (e) {  
			e.preventDefault()
			const isChecked =$(this).is(':checked')
			if(isChecked){
				$('#input-jam-selesai').val('Selesai')
				$('#input-jam-selesai').attr('readonly', 'readonly');
			}else{
				$('#input-jam-selesai').val('')
				$('#input-jam-selesai').removeAttr('readonly');
			}
		})

		const resetForm = () => {
			$('#input-date-range').val('')
			$('#input-jam-mulai').val('')
			$('#input-jam-selesai').val('')
			$('#input-kegiatan').val('')
			$('#input-tempat').val('')
			$('#input-pelaksana').val('')
			$('#input-disposisi').val('')
			$('#input-undangan').val('')
			$('#input-materi').val('')
			$('#input-absen').val('')
			$('#input-notulen').val('')
		}

		const resetError = () => {
			$('#error-date-range').text('')
			$('#error-jam-mulai').text('')
			$('#error-jam-selesai').text('')
			$('#error-kegiatan').text('')
			$('#error-tempat').text('')
			$('#error-pelaksana').text('')
			$('#error-disposisi').text('')
			$('#error-undangan').text('')
			$('#error-materi').text('')
			$('#error-absen').text('')
			$('#error-notulen').text('')
		}

		$('.btn-save').on('click', async function (e) {  
			e.preventDefault()
			setLoading(e)
			const form = new FormData( $('#form-agenda')[0] )
			const url = "{{ route('agenda.edit', $agenda->id) }}"
			try {
				const response = await axios.post(url, form)
				resetForm()
				hideLoading(e, "Save")
				window.location.href ="{{ route('agenda.index') }}"
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