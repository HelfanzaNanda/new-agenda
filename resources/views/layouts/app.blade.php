@extends('layouts.base')

@section('base-styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

	
	@stack('styles')
@endsection

@section('body')
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
	@include('layouts.partials._navbar')
	{{-- @include('layouts.partials._ui-theme-setting')     --}}
	<div class="app-main">
			    		
		@include('layouts.partials._sidebar')
			
		<div class="app-main__outer">
			<div class="app-main__inner">
				@yield('content')
			</div>
			
			@include('layouts.partials._footer')
		</div>
		
		<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
	</div>
</div>
@endsection

@section('base-scripts')
	@include('layouts.partials._script')
	@stack('scripts')
@endsection

@section('modal')
	@yield('modal')	
@endsection