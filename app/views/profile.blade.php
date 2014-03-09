@extends('layout')

<!-- Change Email Modal -->
<div class="modal fade" id="changeEmailModal" tabindex="-1" role="dialog" aria-labelledby="changeEmailModalLabel" aria-hidden="true" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="changeEmailModalLabel">Change Email</h4>
			</div>
			<div class="modal-body">
				After setting a new email here, you need to verify that email within 24 hours.
				<div class="alert" id="email-change-message"></div>
				<form class="form-horizontal" id="email-change-form" action={{ action('UserController@postChangeUserEmail') }} method="post">
					<fieldset>

						<div class="form-group">
							<label class="col-md-4 control-label" for="email">Email</label>
							<div class="col-md-5">
								<input id="email" name="email" type="email" placeholder="" class="form-control input-md" autofocus required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-email-change"></label>
							<div class="col-md-4">
								<button id="submit-email-change" name="submit-email-change" class="btn btn-primary">Submit</button>
							</div>
						</div>

					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

@section('content')

<?php $user = Auth::user(); ?>

<div class="container" id="main">
	
	<h2 class="title">Profile</h2>
	
	<!-- User information material -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">User Information</h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="custom-table table">
					<tr>
						<td>
							<strong>Name</strong>
						</td>
						<td>
							{{ $user->firstname." ".$user->lastname }}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Email Address</strong>
						</td>
						<td>
							<span id="user-email">{{ $user->email }}</span> <a href="#" data-toggle="modal" data-target="#changeEmailModal">Change Email</a>
						</td>
					</tr>
					<tr>
						<td>
							<strong>Member Since</strong>
						</td>
						<td>
							{{ $user->created_at }}
						</td>
					</tr>
					<tr>
						<td>
							<strong>Member ID</strong>
						</td>
						<td>
							{{ $user->id }}
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<!-- Download user information here -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Get Information</h4>
		</div>
		<div class="panel-body">
			<a href="#">Download User Information</a>
		</div>
	</div>
	
	<!-- Delete the Account Label -->
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h5 class="panel-title">Delete User</h5>
		</div>
		<div class="panel-body">
			<a href="/profile">Delete Account</a>
		</div>
	</div>
	
</div>

@stop