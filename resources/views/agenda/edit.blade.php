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
	.select2-container--default .select2-selection--single .select2-selection__rendered {
		color: #444;
		line-height: 28px;
		display: block;
		width: auto;
		height: calc(2.25rem + 2px);
		padding: .375rem .75rem;
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #495057;
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: .25rem;
	}
	.select2-selection{
		border: none!important;
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
						<div class="col-md-6">
							
							<div class="form-group">
								<label for="date_range">Tanggal</label>
								<input type="text" name="date_range" id="input-date-range" 
								value="{{ $agenda['daterange'] }}"
								class="form-control daterange">
								<input type="hidden" name="tanggal_mulai" id="input-tanggal_mulai">
								<input type="hidden" name="tanggal_selesai" id="input-tanggal_selesai">
								<x-validation-error id="error-date_range" />
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="jam_mulai">Jam Mulai</label>
										<input type="text" name="jam_mulai" id="input-jam-mulai" 
										value="{{ $agenda->jam_mulai }}"
										class="form-control timepicker">
										<x-validation-error id="error-jam_mulai"/>
									</div>
								</div>
								<div class="col-md-6">
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
								<label for="disposisi">Disposisi</label>
								<select name="disposisi" id="input-disposisi" class="form-control select-single">
									<option value="" selected disabled>Pilih Disposisi</option>
									@foreach ($users as $user)
										<option 
										{{ $user->id == $agenda->disposisi ? 'selected' : '' }}
										value="{{ $user->id }}">{{ $user->name .' - '. ($user->roles()->count() ? $user->getRoleNames()[0] : '') }}</option>
									@endforeach
								</select>
								<x-validation-error id="error-disposisi"/>
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
							<div class="form-group">
								<label for="pelaksana">Pelaksana Kegiatan</label>
								<input type="text" name="pelaksana" id="input-pelaksana" class="form-control"
								value="{{ old('pelaksana') ?? $agenda->pelaksana_kegiatan }}">
								<x-validation-error id="error-pelaksana"/>
							</div>

						</div>
						<div class="col-md-6">
							
							<div class="row">
								<div class="col-md-6">
									<label class="d-block" for="undangan">Undangan</label>
									<input name="undangan" class="undangan" onchange="showPreviewImage(this)" type="file" id="undangan-btn" hidden/>
									<label class="d-block text-center btn btn-outline-primary btn-sm btn-block" for="undangan-btn"><i class="fas fa-upload"></i>&nbsp;  Pilih File</label>
									<img id="img-undangan" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
									<x-validation-error id="error-undangan"/>
								</div>
								<div class="col-md-6">
									<label class="d-block" for="materi">Materi</label>
									<input name="materi" class="materi" onchange="showPreviewImage(this)" type="file" id="materi-btn" hidden/>
									<label class="d-block text-center btn btn-outline-primary btn-sm btn-block" for="materi-btn"><i class="fas fa-upload"></i>&nbsp;  Pilih File</label>
									<img id="img-materi" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
									<x-validation-error id="error-materi"/>
								</div>
								<div class="col-md-6">
									<label class="d-block" for="absen">Daftar Hadir</label>
									<input name="absen" class="absen" onchange="showPreviewImage(this)" type="file" id="absen-btn" hidden/>
									<label class="d-block text-center btn btn-outline-primary btn-sm btn-block" for="absen-btn"><i class="fas fa-upload"></i>&nbsp;  Pilih File</label>
									<img id="img-absen" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
									<x-validation-error id="error-absen"/>
								</div>
								<div class="col-md-6">
									<label class="d-block" for="notulen">Notulen</label>
									<input name="notulen" class="notulen" onchange="showPreviewImage(this)" type="file" id="notulen-btn" hidden/>
									<label class="d-block text-center btn btn-outline-primary btn-sm btn-block" for="notulen-btn"><i class="fas fa-upload"></i>&nbsp;  Pilih File</label>
									<img id="img-notulen" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
									<x-validation-error id="error-notulen"/>
								</div>
							</div>
							<div class=" mb-3">
								<label class="block">Dokumentasi</label>
								<div class="d-flex documentations">
									<div class="mb-3 col-file-0">
										<input id="choose-file-0" name="dokumentasi[]" onchange="addDocs(this)" type="file" hidden/>
										<img id="img-doc-0" src="https://via.placeholder.com/150" alt="" style="width: 100px; height: 100px; object-fit: cover; object-position: center">
									</div>
									<div class="mb-3">
										<label class="btn btn-outline-primary btn-add-item btn-block d-flex justify-content-center align-items-center" 
										style="height: 100px; width: 100px" for="choose-file-0">
											<i class="fas fa-upload"></i>
										</label>
									</div>
								</div>
								<x-validation-error id="error-dokumentasi[0]"/>
							</div>
						</div>
					</div>
					<hr>
					

					<div>
						<a href="{{ route('agenda.index') }}" type="button" class="btn btn-secondary" > <i class="fa fa-chevron-left"></i> Kembali</a>
						<button type="button" class="btn-save btn btn-primary"> <i class="fa fa-save"></i> Simpan</button>
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

		let indexDoc = 0
		function addDocs(input) {
			$('.col-file-'+indexDoc).css('display', '')
			if (input.files && input.files[0]) {
				$('#img-doc-'+indexDoc).attr('src', URL.createObjectURL(event.target.files[0]))
			}
			indexDoc++
			$('.btn-add-item').removeAttr('for').attr('for', 'choose-file-'+indexDoc)
			$('.documentations').prepend(showItem());
		}

		$(document).on('click', '.btn-remove-item', function (e) {  
			e.preventDefault()
			const key = $(this).data('key')
			$('.col-file-'+key).remove()
		})

		function showItem() {
			let item = ''
				item += '<div class="col-md-2 mb-3 col-file-'+indexDoc+'" style="display:none">'
				item += '	<input id="choose-file-'+indexDoc+'" name="dokumentasi[]" onchange="addDocs(this)" type="file" hidden/>'
				item += '	<img id="img-doc-'+indexDoc+'" src="https://via.placeholder.com/150" alt="" style="width: 100px; height: 100px; object-fit: cover; object-position: center">'
				item += '	<button data-key="'+indexDoc+'" class="btn btn-remove-item btn-danger btn-block btn-sm" style="width: 100px">Hapus</button>'
				item += '</div>'
			return item;
		}

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
				//defaultTime: '08:00',
				startTime: '08:00',
				dynamic: false,
				dropdown: true,
				scrollbar: true
			});
		})


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