@extends('layouts.app')
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush
@section('content')
<div class="app-page-title" style="margin-bottom: 0">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="metismenu-icon fas fa-user icon-gradient bg-happy-itmeo">
				</i>
			</div>
			<div>Disposisi
				{{-- <div class="page-title-subheading">Tables are the backbone of almost all web applications.
				</div> --}}
			</div>
		</div>
		<div class="page-title-actions">
			<a href="{{ route('disposisi.create') }}" class="btn-shadow mr-3 btn btn-primary">
				<i class="fas fa-plus"></i>
				 Tambah Disposisi
			</a>
		</div>    
	</div>
</div>            
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				{{-- <div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Filter Tanggal</label>
							<input type="text" class="form-control form-control-sm daterange" name="tanggal" id="input-tanggal">
							<input type="hidden" name="tanggal_mulai" id="input-tanggal_mulai">
							<input type="hidden" name="tanggal_selesao" id="input-tanggal_selesai">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Filter Pelaksana Kegiatan</label>
							<input type="text" class="form-control form-control-sm pelaksana" name="pelaksana" id="input-pelaksana">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="">Filter Disposisi</label>
							<input type="text" class="form-control form-control-sm disposisi" name="disposisi" id="input-disposisi">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for=""> Filter Status</label>
							<select class="form-control form-control-sm status" name="status" id="input-status">
								<option value="" disabled selected>Pilih Status</option>
								<option value="1">Di Konfirmasi</option>
								<option value="0">Belum Konfirmasi</option>
							</select>
						</div>
					</div>
				</div> --}}
				@include('components.datatables-default',[
					'url' => route('disposisi.datatables'),
					'columns'=> [
						'tanggal'	=> '<th>Tanggal</th>',
						'no_surat'	=> '<th>No Surat</th>',
						'dari'	=> '<th>Dari</th>',
						'kepada'	=> '<th>Kepada</th>',
						'agenda'	=> '<th>Agenda</th>',
						'perihal'	=> '<th>Perihal</th>',
						'catatan'	=> '<th>Catatan</th>',
						'lampiran'	=> '<th>Lampiran</th>',
						'status'	=> '<th>Status</th>',
						'_buttons'=> '<th>Action</th>',
					],
					'filters' => [
						'tanggal_mulai', 'tanggal_selesai', 'pelaksana', 'disposisi', 'status'
					]
				])
			</div>
		</div>
	</div>
</div>
@endsection

@section('modal')
	@include('disposisi.modal')
@endsection

@push('scripts')
	<script>

		$(document).on('click', '.btn-detail', async function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url= "{{ route('disposisi.detail', '') }}"+"/"+id 
			
			try {
				let response = await axios.get(url)
				$('.modal-title').text('Detail Disposisi')
				$('.text-no-surat').text(response.data.no_surat)
				$('.text-tanggal').text(response.data.tanggal_format)
				$('.text-dari').text(response.data.dari.name)
				$('.text-kepada').text(response.data.kepada.name)
				$('.text-agenda').text(response.data.agenda.kegiatan)
				$('.text-perihal').text(response.data.perihal)
				$('.text-catatan').text(response.data.catatan)
				if(response.data.file_surat){
					$('.img-file-surat').attr('src', response.data.file_surat)
					$('.img-file-surat').show()
					$('.img-file-surat-notfound').hide()
				}else{
					$('.img-file-surat-notfound').show()
					$('.img-file-surat-notfound').html('<b>-Tidak Ada File-</b>')
					$('.img-file-surat').hide()
				}
				
				let div = ''
				if(response.data.lampirans.length > 0){
					$.each(response.data.lampirans, function (index, value) {
						div += '<img src="'+value.filename+'" class="mb-2 img-lam-'+index+'" width="100" height="100"'
						div +=	'style="object-fit: cover; object-position: center">'
					})
					$('.lampirans').append(div)
					$('.img-lampiran-notfound').hide()
				}else{
					$('.img-lampiran-notfound').show()
					$('.img-lampiran-notfound').html('<b>-Tidak Ada File-</b>')
				}
				
				$('#modal-disposisi').modal('show')
			} catch (error) {
				
			}
			
		})
		$(document).on('click', '.btn-delete', function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url = "{{ route('disposisi.delete', '') }}"+"/"+id
			deleteData(url, null, true)
		})

		$(document).on('click', '.btn-download', async function (e) {  
			e.preventDefault()
			const file = $(this).data('file')
			const url = "{{ route('disposisi.download') }}"
			location = url+"?file="+file
			
		})

	</script>
@endpush