@extends('layouts.base')

@section('base-styles')
	@stack('styles')
@endsection

@section('body')
<div class="row justify-content-center vh-100 align-items-center" 
	style="position: relative; overflow-x: hidden; ">
	<div class="col-md-5">
		@yield('content')
	</div>
</div>
@endsection

@section('base-scripts')
	@stack('scripts')
@endsection