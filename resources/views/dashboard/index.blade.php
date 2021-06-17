@extends('layouts.app')

@section('content')
<style>
	.img-dashboard {
		background-image: url('/images/bg.jpg');
		height: 300px;
		width: 100%;
		object-fit: cover;
		object-position: center;
		border-radius: 5px;
		padding: 0 100px;
	}
</style>

<div class="row" style="margin-top: 0">
	<div class="col-md-12">
		<div class="img-dashboard d-flex justify-content-center align-items-center mb-5">
			<div class="text-white text-center" style="font-weight: bold; font-size: 30px">AGENDA KEGIATAN KEDEPUTIAN
				BIDANG PENGELOLAAN INFRASTRUKTUR KAWASAN PERBATASAN</div>
		</div>

		<div class="card">
			<div class="card-body">
				<nav class="nav nav-pills justify-content-center nav-justified mb-3" id="pills-tab" role="tablist">
					@foreach ($results as $result)
						<a class="nav-item position-relative nav-link {{ $loop->first ? 'active' : '' }}" data-date="{{ $result['date'] }}" id="pills-{{ $result['date'] }}" data-toggle="pill" 
						href="#pills" role="tab"
						aria-controls="pills" aria-selected="false">
						@if ($result['count'] > 0)
							<span class="position-absolute text-white px-1 bg-danger rounded"
							style="top: -10px; right: -3px; z-index: 100;">{{ $result['count'] }}</span>
						@endif
						<span>{{ $result['date'] }}</span>	
						
					</a>
					@endforeach
				</nav>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills" role="tabpanel" 
					aria-labelledby="pills-tab">
						<table class="table table-hover table-bordered table-sm" id="datatable">
							<thead>
								<tr class="font-weight-bold">
								<th style="width: 1%">#</th>
								<th>File Materi</th>
								<th>File Undangan</th>
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
				}
			},
			"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'file_materi', name: 'file_materi'},
				{data: 'file_undangan', name: 'file_undangan'},
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