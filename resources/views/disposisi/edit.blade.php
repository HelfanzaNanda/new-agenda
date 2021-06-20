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
			<div>Edit Disposisi
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
				<form id="form-disposisi">
					@csrf
					<div class="row">
						<div class="col-md-6">	
							<div class="form-group">
								<label for="input-no-surat">No Surat</label>
								<input type="text" name="no_surat" id="input-no-surat"
								readonly class="form-control bg-white" value="{{ $disposisi->no_surat }}">
							</div>
							<div class="form-group">
								<label for="tanggal">Tanggal</label>
								<input type="text" name="tanggal" id="input-tanggal" 
								value="{{ $disposisi->tanggal->format('m/d/Y') }}"
								class="form-control datepicker bg-white" readonly>
								<x-validation-error id="error-tanggal" />
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="jam_mulai" class="d-block">Dari</label>
										<select name="dari" id="input-dari" class="form-control select-single">
											<option value="" selected disabled>Pilih User</option>
											@foreach ($users as $user)
												<option value="{{ $user->id }}"
													{{ $user->id == $disposisi->dari_id ? 'selected' : '' }}>
													{{ $user->name .' - '. ($user->roles()->count() ? $user->getRoleNames()[0] : '') }}
												</option>
											@endforeach
										</select>
										<x-validation-error class="mt-5" id="error-dari"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="jam_mulai" class="d-block">Kepada</label>
										<select name="kepada" id="input-kepada" class="form-control select-single">
											<option value="" selected disabled>Pilih User</option>
											@foreach ($users as $user)
												<option value="{{ $user->id }}"
													{{ $user->id == $disposisi->kepada_id ? 'selected' : '' }}>
													{{ $user->name .' - '. ($user->roles()->count() ? $user->getRoleNames()[0] : '') }}
												</option>
											@endforeach
										</select>
										<x-validation-error class="mt-5" id="error-kepada"/>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="agenda">Agenda</label>
								<select name="agenda" id="input-agenda" class="form-control select-single">
									<option value="" selected disabled>Pilih Agenda</option>
									@foreach ($agendas as $agenda)
										<option value="{{ $agenda->id }}"
											{{ $agenda->id == $disposisi->agenda_id ? 'selected' : '' }}>
											{{ $agenda->kegiatan }}
										</option>
									@endforeach
								</select>
								<x-validation-error id="error-agenda"/>
							</div>

							<div class="form-group">
								<label for="perihal">Perihal</label>
								<input type="text" name="perihal" id="input-perihal" class="form-control"
								value="{{ old('perihal') ?? $disposisi->perihal }}">
								<x-validation-error id="error-perihal"/>
							</div>
							<div class="form-group">
								<label for="catatan">Catatan</label>
								<input type="text" name="catatan" id="input-catatan" class="form-control"
								value="{{ old('catatan') ?? ($disposisi->catatan ?? '-') }}">
								<x-validation-error id="error-catatan"/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="d-block" for="surat">Surat</label>
								<input name="surat" class="surat" onchange="showPreviewImage(this)" type="file" id="surat-btn" hidden/>
								<label class="d-block text-center btn btn-outline-primary btn-sm btn-block" for="surat-btn"><i class="fas fa-upload"></i>&nbsp;  Pilih File</label>
								<img id="img-surat" src="" alt="" style="display: none; width: 100px; height: 100px; object-fit: cover; object-position: center">
								<x-validation-error id="error-surat"/>
							</div>
							<div class=" mb-3">
								<label class="block">lampiran</label>
								<div class="d-flex lampirans">
									<div class="mb-3 col-file-0">
										<input id="choose-file-0" name="lampiran[]" onchange="addLampiran(this)" type="file" hidden/>
										<img id="img-doc-0" src="https://via.placeholder.com/150" alt="" style="width: 100px; height: 100px; object-fit: cover; object-position: center">
									</div>
									<div class="mb-3">
										<label class="btn btn-outline-primary btn-add-item btn-block d-flex justify-content-center align-items-center" 
										style="height: 100px; width: 100px" for="choose-file-0">
											<i class="fas fa-upload"></i>
										</label>
									</div>
								</div>
								<x-validation-error id="error-lampiran[0]"/>
							</div>
						</div>
					</div>
					<hr/>
					<div>
						<a href="{{ route('agenda.index') }}" type="button" class="btn btn-secondary" >Kembali</a>
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
		let indexLampiran = 0
		function addLampiran(input) {
			$('.col-file-'+indexLampiran).css('display', '')
			if (input.files && input.files[0]) {
				$('#img-doc-'+indexLampiran).attr('src', URL.createObjectURL(event.target.files[0]))
			}
			indexLampiran++
			$('.btn-add-item').removeAttr('for').attr('for', 'choose-file-'+indexLampiran)
			$('.lampirans').prepend(showItem());
		}

		$(document).on('click', '.btn-remove-item', function (e) {  
			e.preventDefault()
			const key = $(this).data('key')
			$('.col-file-'+key).remove()
		})

		function showItem() {
			let item = ''
				item += '<div class="col-md-2 mb-3 col-file-'+indexLampiran+'" style="display:none">'
				item += '	<input id="choose-file-'+indexLampiran+'" name="lampiran[]" onchange="addLampiran(this)" type="file" hidden/>'
				item += '	<img id="img-doc-'+indexLampiran+'" src="https://via.placeholder.com/150" alt="" style="width: 100px; height: 100px; object-fit: cover; object-position: center">'
				item += '	<button data-key="'+indexLampiran+'" class="btn btn-remove-item btn-danger btn-block btn-sm" style="width: 100px">Hapus</button>'
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
			$('.datepicker').datepicker({
				format: "dd MMMM yyyy",
				minDate: new Date()
			});
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
			const form = new FormData( $('#form-disposisi')[0] )
			const url = "{{ route('disposisi.edit', $disposisi->id) }}"
			try {
				const response = await axios.post(url, form)
				resetForm()
				hideLoading(e, "Simpan")
				window.location.href ="{{ route('disposisi.index') }}"
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