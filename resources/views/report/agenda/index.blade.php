@extends('layouts.app')
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush
@section('content')
<div class="app-page-title" style="margin-bottom: 0">
	<div class="page-title-wrapper">
		<div class="page-title-heading">
			<div class="page-title-icon">
				<i class="metismenu-icon fas fa-file icon-gradient bg-happy-itmeo">
				</i>
			</div>
			<div>Report Agenda
				{{-- <div class="page-title-subheading">Tables are the backbone of almost all web applications.
				</div> --}}
			</div>
		</div>
		<div class="page-title-actions"></div>    
	</div>
</div>            
<div class="row">
	<div class="col-md-12">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<form action="{{ route('report.agenda.pdf') }}" target="_blank" method="POST"
				class="d-flex mb-2 align-items-center justify-content-center">
					@csrf
					<div class="mr-3">
						<select name="month" id="filter-month" class="form-control">
							@foreach ($months as $key => $month)
								<option value="{{ $key+1 }}" data-name="{{ $month }}"
								{{ $month == $selected_month ? 'selected' : '' }}
								>{{ $month }}</option>
							@endforeach
						</select>
					</div>
					<div class="mr-3">
						<select name="year" id="filter-year" class="form-control">
							@foreach ($years as $key => $year)
								<option value="{{ $year }}"
								{{ $year == $selected_year ? 'selected' : '' }}
								>{{ $year }}</option>
							@endforeach
						</select>
					</div>
					<div class="mr-3">
						<button type="button" class="btn btn-primary text-white" id="btn-filter">
							<i class="fas fa-html5"></i> Show HTML Report
						</button>
					</div>
					<div class="mr-3">
						<button type="submit" class="btn btn-primary text-white">
							<i class="fas fa-file-pdf-o"></i> Get Report File
						</button>
					</div>
				</form>
				<h5 class="text-center mb-3">AGENDA KEGIATAN KEDEPUTIAN BIDANG PENGELOLAAN INFRASTRUKTUR KAWASAN PERBATASAN
					BULAN <span class="text-selected-month text-uppercase">{{ $selected_month }}</span>  <span class="text-selected-year">{{ $selected_year }}</span></h5>
				@include('components.datatables-default',[
					'url' => route('report.agenda.datatables'),
					'columns'=> [
						'h/t'	=> '<th>H/T</th>',
						'jam'	=> '<th >Jam</th>',
						'kegiatan'	=> '<th >Kegiatan</th>',
						'tempat'	=> '<th >Tempat</th>',
						'hadir'	=> '<th >Hadir / Disposisi</th>',
						'pelaksana_kegiatan'	=> '<th>Pelaksana Kegiatan</th>'
					],
					'filters' => [
						'month', 'year'
					]
				])
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')

	<script>
		$(document).on('click', '#btn-filter', function (e) {  
			e.preventDefault()
			$('.text-selected-month').text($('#filter-month').find(':selected').data('name'))
			$('.text-selected-year').text($('#filter-year').val())
			$('#datatable').DataTable().ajax.reload()
		})
	</script>
@endpush