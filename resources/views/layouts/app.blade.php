@extends('layouts.base')

@section('base-styles')
	@stack('styles')
@endsection

@section('body')
<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
	@include('layouts.partials._navbar')
	@include('layouts.partials._ui-theme-setting')    
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