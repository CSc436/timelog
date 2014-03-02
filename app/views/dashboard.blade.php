@extends('layout')
<!-- weather API Key: d513969ef432e427 -->
@section('content')
	<h2 class="title">Dashboard</h2>

	<div id="dashboard-container">
		<div id="dashboard-left-sidebar" class="left-panel" 
		style="width:200px;height:800px;padding:10px;" >
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">Quick Links</h4>
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
		<div id="weather"></div>
		<div id="categories"></div>
		<div id="trends"></div>
		<div id="dashboard-right-sidebar">
			<div id="deadlines"></div>
			<div id="achievements"></div>
		</div>
		
	</div>
@stop