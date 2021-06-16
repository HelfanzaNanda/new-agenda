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
<div class="app-page-title">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="pe-7s-car icon-gradient bg-mean-fruit">
				</i>
			</div>
			<div> Dashboard</div>
		</div>
		<div class="page-title-actions">

		</div>
	</div>
</div>

<div class="row" style="height: 1000px">
	<div class="col-md-12">
		<div class="img-dashboard d-flex justify-content-center align-items-center mb-5">
			<div class="text-white text-center" style="font-weight: bold; font-size: 30px">AGENDA KEGIATAN KEDEPUTIAN
				BIDANG PENGELOLAAN INFRASTRUKTUR KAWASAN PERBATASAN</div>
			{{-- <img src="{{ asset('images/bg.jpg') }}" style="height: 300px; width: 100%; border-radius: 5px"> --}}
		</div>

		<nav class="nav nav-pills justify-content-center nav-justified mb-3" id="pills-tab" role="tablist">
			{{-- <a class="nav-item nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab">Home</a> --}}
			@foreach ($dates as $date)
				<a class="nav-item nav-link {{ $loop->first ? 'active' : '' }}" data-date="{{ $date }}" id="pills-{{ $date }}" data-toggle="pill" 
				href="#pills" role="tab"
				aria-controls="pills" aria-selected="false">{{ $date }}</a>
			@endforeach
		</nav>
		<div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade show active" id="pills" role="tabpanel" 
			aria-labelledby="pills-tab">
				{{-- @include('components.datatables-default', $data) --}}
				<table class="table table-hover table-bordered table-sm" id="datatable">
					<thead>
						<tr class="font-weight-bold">
							<th style="width: 1%">#</th>
							@foreach($columns as $column=>$th)
								{!! $th !!}
							@endforeach
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
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
				@foreach($columns as $column=>$title)
					{ "data": "{{$column}}" },
				@endforeach
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