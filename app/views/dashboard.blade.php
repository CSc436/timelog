@extends('layout')
<!-- weather API Key: d513969ef432e427 -->
@section('content')
	<h2 class="title">Dashboard</h2>

	<div id="dashboard-container">
		<div id="dashboard-left-sidebar" class="pull-left">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Quick Links</h4>
					</div>
					<div class="panel-body">
						<p><tr><strong>Create Tasks</strong></tr> </p>
						<p><tr><strong>View Tasks</strong></tr> </p>
						<p><tr><strong>Completed Tasks</strong></tr> </p>
						<p><tr><strong>View Data</strong></tr> </p>
						<p><tr><strong>Achievements</strong></tr> </p>
					</div>
				</div>
		</div>

		<div id="weather">
			<div id="weather-condition"></div>
			<div id="temperature"></div>
			<div id="location"></div>
			<div id="time"></div>
		</div>
		
		<div id="categories"></div>
		
		<div id="trends"></div>
		
		
		<div id="dashboard-right-sidebar" class="pull-right" >
			<div id="deadlines">
				<h3 class="panel- title">Deadlines</h3>
				<div class="panel-body">
					
				</div>
			</div>
			<div id="achievements">
				<h4 class="panel- title">Achievements</h4>
				<div class="panel-body">
					Hello
				</div>
			</div>
				
		</div>
	</div>

	<link href="{{ URL::asset('css/dashboard.css') }}" rel="stylesheet">
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
	<script src="{{ URL::asset('js/dashboard.js') }}"></script>
@stop