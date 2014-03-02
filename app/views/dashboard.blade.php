@extends('layout')

@section('content')
	<h2 class="title">Dashboard</h2>

	<div id="dashboard-container">
		<div id="dashboard-left-sidebar">
		</div>
		<div id="weather">
			<div id="weather-condition"></div>
			<div id="temperature"></div>
			<div id="location"></div>
			<div id="time"></div>
		</div>
		<div id="categories"></div>
		<div id="trends"></div>
		<div id="dashboard-right-sidebar">
			<div id="deadlines"></div>
			<div id="achievements"></div>
		</div>
		
	</div>

	<link href="{{ URL::asset('css/dashboard.css') }}" rel="stylesheet">
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
	<script src="{{ URL::asset('js/dashboard.js') }}"></script>
@stop