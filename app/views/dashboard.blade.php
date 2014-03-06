@extends('layout')
<!-- weather API Key: d513969ef432e427 -->
@section('content')

	<div class="container" id="main">

	<h2 class="title">Dashboard</h2>

	<div id="dashboard-container" class="row">

		<!-- Left sidebar column -->
		<div id="dashboard-left-sidebar" class="col-md-2 pull-left">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Quick Links</h3>
					</div>
					<div class="panel-body">
						<p><a href="/log/view">View Tasks</a></p>
						<p><a href="/tasks/completed">Completed Tasks</a></p>
						<p><a href="/log/view">View Data</a></p>
						<p><a href="/achievements">Achievements</a></p>
						<p><a href="/addlog_cal">Create Tasks</a></p>
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
		<div id="categories" class="box col-md-4">
			<svg></svg>
		</div>
		
		<!-- Right sidebar column -->
		<div id="dashboard-right-sidebar" class="col-md-3 pull-right" >
			
			<div id="deadlines" class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Deadlines</h3>
				</div>
				<div class="panel-body">
					<p>Finish HW</p>
					<p>Attend ACM meeting</p>
				</div>
			</div>

			<div id="achievements" class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Achievements</h3>
				</div>
				<div class="panel-body">
					Congrats! You are like the most productive person in the world.
				</div>
			</div>

		</div>

		<!-- Trends column -->
		<div id="trends" class="box col-md-6">
			
		</div>

	</div>

	</div>

	<link href="{{ URL::asset('css/dashboard.css') }}" rel="stylesheet">
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
	<script src="{{ URL::asset('js/dashboard.js') }}"></script>
@stop