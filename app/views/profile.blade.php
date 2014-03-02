@extends('layout')

@section('content')
	<?php $user = Auth::user(); ?>
	
	<h2 class="title">Profile</h2>
	<!-- User information material -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">User Information</h3>
		</div>
		<div class="panel-body">
			
			<p><tr><strong>Full Name: </strong></tr>{{ $user->firstname." ".$user->lastname }}</p> 
			<p><tr><strong>Email Address: </strong></tr>{{ $user->email }}</p>
			<p><tr><strong>Member Since: </strong></tr>{{ $user->created_at }}</p>
			<p><tr><strong>Member ID: </strong></tr>{{ $user->id }}</p>
		</div>
	</div>
	<!-- Download user information here -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Get Information</h4>
		</div>
		<div class="panel-body">
			<p><tr><strong>Download User Information</strong></tr> </p>
		</div>
	</div>
	<!-- Delete the Account Label -->
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h5 class="panel-title">Delete User</h5>
		</div>
		<div class="panel-body">
			<p><tr><strong><a href="localhost:8000/profile">Delete Account</a></strong></tr></p>
		</div>
	</div>
	
	
@stop