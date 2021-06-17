@extends('layouts.app')
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush
@section('content')
<div class="app-page-title" style="margin-bottom: 0">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="metismenu-icon fas fa-calendar icon-gradient bg-happy-itmeo">
				</i>
			</div>
			<div>Agenda
				{{-- <div class="page-title-subheading">Tables are the backbone of almost all web applications.
				</div> --}}
			</div>
		</div>
		<div class="page-title-actions">
			<a href="{{ route('agenda.create') }}" class="btn-shadow mr-3 btn btn-primary">
				Tambah Agenda
			</a>
		</div>    
	</div>
</div>            
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				@include('components.datatables-expandable',[
					'url' => route('agenda.datatables'),
					'columns'=> [
						'h/t'	=> '<th>H/T</th>',
						'kegiatan'	=> '<th >Kegiatan</th>',
						'pelaksana_kegiatan'	=> '<th>Pelaksana Kegiatan</th>',
						'disposisi'	=> '<th>Disposisi</th>',
						'status'	=> '<th>Status</th>',
						'file_materi'	=> '<th>File Materi</th>',
						'file_undangan'	=> '<th>File Undangan</th>',
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
	<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

	<script>

		$(document).on('click', '.btn-detail', async function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url= "{{ route('agenda.detail', '') }}"+"/"+id 
			
			try {
				let response = await axios.get(url)
				console.log(response.data);
				$('.modal-title').text('Detail Agenda')
				$('.text-daterange').text(response.data.daterange)
				$('.text-jam-mulai').text(response.data.jam_mulai)
				$('.text-jam-selesai').text(response.data.jam_selesai)
				$('.text-kegiatan').text(response.data.kegiatan)
				$('.text-tempat').text(response.data.tempat)
				$('.text-pelaksana-kegiatan').text(response.data.pelaksana_kegiatan)
				$('.text-disposisi').text(response.data.user.name)
				if(response.data.undangan){
					$('.img-undangan').attr('src', response.data.undangan)
					$('.img-undangan').show()
				}else{
					$('.img-undangan').hide()
				}
				if(response.data.materi){
					$('.img-materi').attr('src', response.data.materi)
					$('.img-materi').show()
				}else{
					$('.img-materi').hide()
				}
				if(response.data.daftar_hadir){
					$('.img-absen').attr('src', response.data.daftar_hadir)
					$('.img-absen').show()
				}else{
					$('.img-absen').hide()
				}
				if(response.data.notulen){
					$('.img-notulen').attr('src', response.data.notulen)
					$('.img-notulen').show()
				}else{
					$('.img-notulen').hide()
				}

				let div = ''
				$.each(response.data.documentations, function (index, value) {  
					console.log(value);
					div += '<img src="'+value.dokumentasi+'" class="mb-2 img-notulen-'+index+'" width="100" height="100"'
					div +=	'style="object-fit: cover; object-position: center">'
				})
				$('.docs').append(div)
				$('#modal-agenda').modal('show')
			} catch (error) {
				
			}
			
		})
		$(document).on('click', '.btn-delete', function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url = "{{ route('agenda.delete', '') }}"+"/"+id
			deleteData(url, null, true)
		})

	</script>
@endpush