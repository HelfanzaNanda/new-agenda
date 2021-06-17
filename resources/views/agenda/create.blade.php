@extends('layouts.app')

@section('content')
<style>
	.ui-timepicker-container {
		z-index: 3500 !important;
	}
	.label-actual-btn {
		background-color: indigo;
		color: white;
		padding: 0.5rem;
		font-family: sans-serif;
		border-radius: 0.3rem;
		cursor: pointer;
	}
</style>
<div class="app-page-title">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
				</i>
			</div>
			<div>Tambah Agenda
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
								<input type="text" name="date_range" id="input-date-range" class="form-control daterange">
								<input type="hidden" name="tanggal_mulai" id="input-tanggal_mulai">
								<input type="hidden" name="tanggal_selesai" id="input-tanggal_selesai">
								<x-validation-error id="error-date_range"/>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="jam_mulai">Jam Mulai</label>
								<input type="text" name="jam_mulai" id="input-jam-mulai" class="form-control timepicker">
								<x-validation-error id="error-jam_mulai"/>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="jam_selesai">Jam Selesai</label>
								<input type="text" name="jam_selesai" id="input-jam-selesai" class="form-control timepicker">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="check-jam-selesai">
									<label class="form-check-label" for="check-jam-selesai">
									  s.d Selesai
									</label>
								</div>
								<x-validation-error id="error-jam_selesai"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="disposisi">Disposisi</label>
								<select name="disposisi" id="input-disposisi" class="form-control select-single">
									<option value="" selected disabled>Pilih Disposisi</option>
									@foreach ($users as $user)
										<option value="{{ $user->id }}">{{ $user->name  .' - '. $user->getRoleNames()[0] }}</option>
									@endforeach
								</select>
								<x-validation-error id="error-disposisi"/>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label for="kegiatan">Kegiatan</label>
								<input type="text" name="kegiatan" id="input-kegiatan" class="form-control">
								<x-validation-error id="error-kegiatan"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="tempat">Tempat</label>
								<input type="text" name="tempat" id="input-tempat" class="form-control">
								<x-validation-error id="error-tempat"/>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="pelaksana">Pelaksana Kegiatan</label>
								<input type="text" name="pelaksana" id="input-pelaksana" class="form-control">
								<x-validation-error id="error-pelaksana"/>
							</div>
						</div>
						
					</div>
					<hr>

					<div class="row">
						<div class="col-md-3">
							<label class="d-block" for="undangan">Undangan</label>
							<input name="undangan" class="undangan" onchange="showPreviewImage(this)" type="file" id="undangan-btn" hidden/>
							<label class="d-block text-center label-actual-btn" for="undangan-btn">Pilih File</label>
							<img id="img-undangan" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
							<x-validation-error id="error-undangan"/>
						</div>
						<div class="col-md-3">
							<label class="d-block" for="materi">Materi</label>
							<input name="materi" class="materi" onchange="showPreviewImage(this)" type="file" id="materi-btn" hidden/>
							<label class="d-block text-center label-actual-btn" for="materi-btn">Pilih File</label>
							<img id="img-materi" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
							<x-validation-error id="error-materi"/>
						</div>
						<div class="col-md-3">
							<label class="d-block" for="absen">Daftar Hadir</label>
							<input name="absen" class="absen" onchange="showPreviewImage(this)" type="file" id="absen-btn" hidden/>
							<label class="d-block text-center label-actual-btn" for="absen-btn">Pilih File</label>
							<img id="img-absen" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
							<x-validation-error id="error-absen"/>
						</div>
						<div class="col-md-3">
							<label class="d-block" for="notulen">Notulen</label>
							<input name="notulen" class="notulen" onchange="showPreviewImage(this)" type="file" id="notulen-btn" hidden/>
							<label class="d-block text-center label-actual-btn" for="notulen-btn">Pilih File</label>
							<img id="img-notulen" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
							<x-validation-error id="error-notulen"/>
						</div>
					</div>
					
					<div class="documentations">
						<div class="d-flex justify-content-end">
							<button class="btn btn-primary btn-add-item">Tambah Dokumentasi</button>
						</div>
						<label class="block">Dokumentasi</label>
						<x-validation-error id="error-dokumentasi[0]"/>
						<div class="row mb-2 align-items-start">
							<div class="col-md-3">
								<input name="dokumentasi[]" class="dokumentasi-0" onchange="showPreviewImage(this)" type="file" id="doc-btn-0" hidden/>
								<label class="d-block text-center label-actual-btn" for="doc-btn-0">Pilih File</label>
								<img id="img-dokumentasi-0" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
							</div>
						</div>
					</div>
					<div>
						<a href="{{ route('agenda.index') }}" type="button" class="btn btn-secondary" >Close</a>
						<button type="button" class="btn-save btn btn-primary">Simpan</button>
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

		function showPreviewImage(input){
			let classes = input.classList.value
			if (input.files && input.files[0]) {
				$('#img-'+classes).css('display', '')
				$('#img-'+classes).attr("src", URL.createObjectURL(event.target.files[0]));
				$('#img-'+classes).on('load', function () {  
					URL.revokeObjectURL($('.img-'+classes).attr("src"))
				})
			}
		}
		
		$(document).ready(function () {  
			$('.select-single').select2();
			$('.daterange').daterangepicker({
				locale: {
					format: 'DD MMMM YYYY'
				},
				minDate: new Date()
			}, function(start, end, label) {
					$('#input-tanggal_selesai').val(end.format('DD-MM-YYYY'))
					$('#input-tanggal_mulai').val(start.format('DD-MM-YYYY'))
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
				item += '<div class="row align-items-start mb-2 row-'+indexItem+'">'
				item += '	<div class="col-md-3">'
				item +=	'		<input name="dokumentasi[]" class="dokumentasi-'+indexItem+'" onchange="showPreviewImage(this)" type="file" id="doc-btn-'+indexItem+'" hidden/>'
				item +=	'		<label class="d-block text-center label-actual-btn" for="doc-btn-'+indexItem+'">Pilih File</label>'
				item +=	'		<img id="img-dokumentasi-'+indexItem+'" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">'
				item += '	</div>'
				item += '	<div class="col-md-3">'
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

		$(document).on('click', '.btn-save', async function (e) {  
			e.preventDefault()
			setLoading(e)
			const form = new FormData( $('#form-agenda')[0] )
			const url = "{{ route('agenda.create') }}"
			try {
				const response = await axios.post(url, form)
				resetForm()
				hideLoading(e, "Simpan")
				window.location.href ="{{ route('agenda.index') }}"
				toastr["success"](response.data.message, "success")
			} catch (error) {
				hideLoading(e, "Simpan")
				if(error.response.status === 422){
					const errors = error.response.data.errors
					Object.keys(errors).map(field => $('#error-'+field).text(errors[field][0]))	
				}	
			}
		})
	</script>

	
@endpush