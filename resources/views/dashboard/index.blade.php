@extends('layouts.app')

@section('content')
<style>
	.img-dashboard {
		/* background-image: url('/images/bg.jpg'); */
		background: #3f6ad8;
		/*height: 300px;*/
		width: 100%;
		object-fit: cover;
		object-position: center;
		border-radius: 5px;
		padding: 20px 100px;
	}
	.nav-link {
		background-color: #eee;
		color: black;
	}
	.navbar-nav>.active>a {
		background-color: #3f6ad8;
		color: white;
	}
</style>

<div class="row" style="margin-top: 0">
	<div class="col-md-12">
		<div class="img-dashboard d-flex justify-content-center align-items-center mb-3">
			<div class="text-white text-center" style="font-weight: bold; font-size: 30px">AGENDA KEGIATAN KEDEPUTIAN
				BIDANG PENGELOLAAN INFRASTRUKTUR KAWASAN PERBATASAN</div>
		</div>

		<div class="card">
			<div class="card-body">
				<nav class="nav nav-pills justify-content-center nav-justified mb-3" id="pills-tab" role="tablist">
					@foreach ($results as $result)
						<a class="nav-item position-relative nav-link justify-content-center {{ $loop->first ? 'active' : '' }}" 
							data-date="{{ $result['date'] }}" 
							id="pills-{{ $result['date'] }}" data-toggle="pill" 
						href="#pills" role="tab"
						aria-controls="pills" aria-selected="false">
						@if ($result['count'] > 0)
							<span class="position-absolute text-white px-1 bg-danger rounded"
							style="    font-size: 10px; top: -7px; right: 3px; z-index: 100;">{{ $result['count'] }}</span>
						@endif
						<span>{{ $result['date'] }}</span>	
						
					</a>
					@endforeach
				</nav>
				
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills" role="tabpanel" 
					aria-labelledby="pills-tab">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="">Filter Pelaksana Kegiatan</label>
									<input type="text" class="form-control form-control-sm pelaksana" name="pelaksana" id="input-pelaksana">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="">Filter Disposisi</label>
									<input type="text" class="form-control form-control-sm disposisi" name="disposisi" id="input-disposisi">
								</div>
							</div>
							<div class="col-md-4">
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
						<table class="table table-hover table-bordered table-sm" id="datatable">
							<thead>
								<tr class="font-weight-bold">
								<th style="width: 1%">#</th>
								<th>File</th>
								<th>Jam</th>
								<th>Agenda</th>
								<th>Tempat</th>
								<th>Pelaksana</th>
								<th>Disposisi</th>
								<th>Status</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

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

	$(document).ready(function () {
		let table = $('#datatable').DataTable({
			"pageLength": 10,
			"processing": true,
			"serverSide": true,
			"orderable": true,
			"ajax":{
				"url": "{{ route('dashboard.datatables') }}",
				"dataType": "json",
				"type": "POST",
				"data":function(d) {
					d._token = "{{csrf_token()}}"
					d.date = $('.nav-link.active').data('date')
					d.disposisi = $('#input-disposisi').val()
					d.pelaksana = $('#input-pelaksana').val()
					d.status = $('#input-status').val()
					console.log(d);
				}
			},
			"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'file', name: 'file', width:'15%'},
				{data: 'jam', name: 'jam'},
				{data: 'kegiatan', name: 'kegiatan'},
				{data: 'tempat', name: 'tempat'},
				{data: 'pelaksana_kegiatan', name: 'pelaksana_kegiatan'},
				{data: 'disposisi', name: 'disposisi'},
				{data: 'status', name: 'status'},
			],
		});
	});

	$('.nav-link').on('click', function (e) {  
		e.preventDefault()
		setTimeout(() => {
			$('#datatable').DataTable().ajax.reload()
		}, 50);
	})
</script>
@endpush