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
				<i class="fas fa-plus"></i>
				 Tambah Agenda
			</a>
		</div>    
	</div>
</div>            
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<div class="row">
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
				</div>
				@include('components.datatables-expandable',[
					'url' => route('agenda.datatables'),
					'columns'=> [
						'h/t'	=> '<th>H/T</th>',
						'kegiatan'	=> '<th >Kegiatan</th>',
						'pelaksana_kegiatan'	=> '<th>Pelaksana Kegiatan</th>',
						'disposisi'	=> '<th>Disposisi</th>',
						'status'	=> '<th>Status</th>',
						'file'	=> '<th>File</th>',
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
	@include('agenda.modal')
@endsection

@push('scripts')
	<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

	<script>
		$('.daterange').daterangepicker({
			locale: {
				format: 'DD MMMM YYYY'
			}
		}, function(start, end, label) {
			$('#input-tanggal_mulai').val(start.format('DD-MM-YYYY'))
			$('#input-tanggal_selesai').val(end.format('DD-MM-YYYY'))
		});

		$('.pelaksana').autocomplete({
			source: function (request, response) {  
				$.ajax({
					url: "{{ route('agenda.search') }}",
					dataType: "json",
					data: {
						key: request.term,
						type: 'pelaksana'
					},
					success: function (data) {
						response($.map(data, function (item) {
							return {
								label: item,
								value: item
							};
						}));
					}
				});
			},
			select: function () {  
				setTimeout(() => {
					$('#datatable').DataTable().ajax.reload()
				}, 50);
			},
			change: function () {  
				setTimeout(() => {
					$('#datatable').DataTable().ajax.reload()
				}, 50);
			}
		});

		$('.disposisi').autocomplete({
			source: function (request, response) {  
				$.ajax({
					url: "{{ route('agenda.search') }}",
					dataType: "json",
					data: {
						key: request.term,
						type: 'disposisi'
					},
					success: function (data) {
						response($.map(data, function (item) {
							return {
								label: item.user.name,
								value: item.user.id
							};
						}));
					}
				});
			},
			select: function () {
				setTimeout(() => {
					$('#datatable').DataTable().ajax.reload()
				}, 50);
			},
			change: function () {  
				setTimeout(() => {
					$('#datatable').DataTable().ajax.reload()
				}, 50);
			}
		});

		$(document).on('change', '.daterange, .disposisi, .pelaksana, .status', function (e) {  
			e.preventDefault()
			$('#datatable').DataTable().ajax.reload()
		})

		$(document).on('click', '.btn-detail', async function (e) {  
			e.preventDefault()
			const id = $(this).data('id')
			const url= "{{ route('agenda.detail', '') }}"+"/"+id 
			
			try {
				let response = await axios.get(url)
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
					$('.img-undangan-notfound').hide()
				}else{
					$('.img-undangan-notfound').show()
					$('.img-undangan-notfound').html('<b>-Tidak Ada File-</b>')
					$('.img-undangan').hide()
				}
				if(response.data.materi){
					$('.img-materi').attr('src', response.data.materi)
					$('.img-materi').show()
					$('.img-materi-notfound').hide()
				}else{
					$('.img-materi-notfound').show()
					$('.img-materi-notfound').html('<b>-Tidak Ada File-</b>')
					$('.img-materi').hide()
				}
				if(response.data.daftar_hadir){
					$('.img-absen').attr('src', response.data.daftar_hadir)
					$('.img-absen').show()
					$('.img-absen-notfound').hide()
				}else{
					$('.img-absen-notfound').show()
					$('.img-absen-notfound').html('<b>-Tidak Ada File-</b>')
					$('.img-absen').hide()
				}
				if(response.data.notulen){
					$('.img-notulen').attr('src', response.data.notulen)
					$('.img-notulen').show()
					$('.img-notulen-notfound').hide()
				}else{
					$('.img-notulen-notfound').show()
					$('.img-notulen-notfound').html('<b>-Tidak Ada File-</b>')
					$('.img-notulen').hide()
				}

				let div = ''
				if(response.data.documentations.length > 0){
					$.each(response.data.documentations, function (index, value) {
						div += '<img src="'+value.dokumentasi+'" class="mb-2 img-notulen-'+index+'" width="100" height="100"'
						div +=	'style="object-fit: cover; object-position: center">'
					})
					$('.docs').append(div)
					$('.img-doc-notfound').hide()
				}else{
					$('.img-doc-notfound').show()
					$('.img-doc-notfound').html('<b>-Tidak Ada File-</b>')
				}
				
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