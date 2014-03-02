@extends('layout')
<!-- weather API Key: d513969ef432e427 -->
@section('content')
	<h2 class="title">Dashboard</h2>

	<div id="dashboard-container" class="row">

		<!-- Left sidebar column -->
		<div id="dashboard-left-sidebar" class="col-md-2 pull-left">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Quick Links</h4>
					</div>
					<div class="panel-body">
						<p>View Tasks</p>
						<p>Completed Tasks</p>
						<p>View Data</p>
						<p>Achievements</p>
						<p>Create Tasks</p>
					</div>
				</div>
		</div>

		<!-- Weather column -->
		<div id="weather" class="box col-md-2">
			<div id="weather-condition"></div>
			<div id="temperature"></div>
			<div id="location"></div>
			<div id="time"></div>
			<div id="date"></div>
		</div>
		
		<!-- Categories column -->
		<div id="categories" class="box col-md-5"></div>
		
		<!-- Trends column -->
		<div id="trends" class="box col-md-6">
			
		</div>
		
		<!-- Right sidebar column -->
		<div id="dashboard-right-sidebar" class="col-md-2 pull-right" >
			<div id="deadlines">
				<h3 class="panel-title">Deadlines</h3>
				<div class="panel-body">
					
				</div>
			</div>
			<div id="achievements">
				<h4 class="panel-title">Achievements</h4>
				<div class="panel-body">
					Congrats! You are the most productive person in the world.
				</div>
			</div>				
		</div>

	</div>

	<link href="{{ URL::asset('css/dashboard.css') }}" rel="stylesheet">
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
	<script src="{{ URL::asset('js/dashboard.js') }}"></script>
@stop