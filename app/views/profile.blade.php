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

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="changePasswordModalLabel">Change Password</h4>
			</div>
			<div class="modal-body">
				Enter the current password, the new password and confirmation.
				<div class="alert" id="password-change-message"></div>
				<form class="form-horizontal" id="password-change-form" action={{ action('UserController@postChangeUserPassword') }} method="post">
					<fieldset>

						<div class="form-group">
							<label class="col-md-4 control-label" for="current-password">Current</label>
							<div class="col-md-5">
								<input id="current-password" name="current-password" type="password" class="form-control input-md" autofocus required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="password">New</label>
							<div class="col-md-5">
								<input id="password" name="password" type="password" class="form-control input-md" autofocus required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="password_confirmation">Confirm</label>
							<div class="col-md-5">
								<input id="password_confirmation" name="password_confirmation" type="password" class="form-control input-md" autofocus required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-password-change"></label>
							<div class="col-md-4">
								<button id="submit-password-change" name="submit-password-change" class="btn btn-primary">Submit</button>
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

<!-- Delete User Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteUserModalLabel">Enter Password</h4>
			</div>
			<div class="modal-body">
				<div class="alert" id="password-change-message"></div>
				<form class="form-horizontal" id="password-change-form" action={{ action('UserController@deleteUser') }} method="post">
					<fieldset>
	

						<div class="form-group">
							<label class="col-md-4 control-label" for="password">Password</label>
							<div class="col-md-5">
								<input id="password" name="password" type="password" class="form-control input-md" autofocus required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-user-delete"></label>
							<div class="col-md-4">
								<button id="submit-user-delete" name="submit-user-delete" class="btn btn-primary">Submit</button>
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
	<?php $err=Session::get('err'); ?>
	@if(isset($err))
		
		<div class="alert alert-danger">
			<strong>Error:</strong>
			@if(count($err) == 1)
				{{{ $err[0] }}}
			@endif
		</div>
	@endif
	
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
					<tr>
						<td>
							<i class="fa fa-key"></i> <a href="#" data-toggle="modal" data-target="#changePasswordModal">Change Password</a>
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
			<a href="#" data-toggle="modal" data-target="#deleteUserModal">Delete Account</a>
		</div>
	</div>
	
</div>
@stop