@extends('layout')

{{-- Various Modals for resetting password, changing email, changin password etc --}}

<!-- Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="resetPasswordModalLabel">Reset Password</h4>
			</div>
			<div class="modal-body">
				Enter the email address that was used to register your account.
				<div class="alert" id="password-reset-message"></div>
				<form class="form-horizontal" id="reset-password-form" action={{ action('RemindersController@postRemind') }} method="post">
					<fieldset>

						<div class="form-group">
							<label class="col-md-4 control-label" for="email">Email</label>
							<div class="col-md-5">
								<input id="email" name="email" type="email" placeholder="" class="form-control input-md" autofocus required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit-password-reset"></label>
							<div class="col-md-4">
								<button id="submit-password-reset" name="submit-password-reset" class="btn btn-primary">Submit</button>
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

<div class="container" id="main">

	<?php $success = Session::get("success"); ?>
	@if(isset($success))
		<div class="alert alert-info">
			{{ $success }}
		</div>
	@endif

	<form class="form-horizontal" action="{{ action('UserController@postUserLogin') }}" method="post">
		<fieldset>
			<!-- Form Name -->
			<legend>Login</legend>

			<!-- Login Error -->
			<?php $error = Session::get("error"); ?>
			@if(isset($error))
				<div class="alert alert-danger">
					{{ $error }}
				</div>
			@endif

			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="email">Email</label>
				<div class="col-md-5">
					<input id="email" name="email" autofocus type="text" placeholder="" class="form-control input-md" required="">
				</div>
			</div>

			<!-- Password input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="password">Password</label>
				<div class="col-md-5">
					<input id="password" name="password" type="password" placeholder="" class="form-control input-md" required="">
				</div>
			</div>

			<!-- Button -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="submit-login"></label>
				<div class="col-md-4">
					<button id="submit-login" name="submit-login" class="btn btn-primary">Login</button>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label" for="submit-login"></label>
				<div class="col-md-4">
					<a href="#" data-toggle="modal" data-target="#resetPasswordModal">Forgot Password</a>
				</div>
			</div>		

		</fieldset>
	</form>

	<legend>Sign up</legend>
	<section id="social-signup">
		<a class="btn btn-primary" href="#" id="signup-email"><i class="fa fa-envelope"></i> Sign Up With Email</a>
		<a class="btn btn-primary" href="/auth/facebook" id="signup-facebook"><i class="fa fa-facebook"></i> Sign Up With Facebook</a>
		<a class="btn btn-primary" href="/auth/google" id="signup-google"><i class="fa fa-google-plus"></i> Sign Up With Google</a>
		<a class="btn btn-primary" href="/auth/twitter" id="signup-twitter"><i class="fa fa-twitter"></i> Sign Up With Twitter</a>		
	</section>
	<section id="signup-email-section">
		<ul>
			@foreach($errors->all() as $error)
			<li>{{{ $error }}}</li>
			@endforeach
		</ul>
		<form class="form-horizontal" id="signup-email-form" action="/signup" method="post">
			<fieldset>
				<!-- Form Name -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="signup-firstname">First Name</label>
					<div class="col-md-5">
						<input id="signup-firstname" name="firstname" type="text" placeholder="" class="form-control input-md" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="signup-lastname">Last Name</label>
					<div class="col-md-5">
						<input id="signup-lastname" name="lastname" type="text" placeholder="" class="form-control input-md" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="signup-password">Password</label>
					<div class="col-md-5">
						<input id="signup-password" name="password" type="password" placeholder="" class="form-control input-md" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="signup-password_confirmation">Confirm Password</label>
					<div class="col-md-5">
						<input id="signup-password_confirmation" name="password_confirmation" type="password" placeholder="" class="form-control input-md" required>
						<span class="help-block">just in case you mistyped it</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">Email</label>
					<div class="col-md-5">
						<input id="email" name="email" type="email" placeholder="" class="form-control input-md" required>
						<span class="help-block">for verification and resetting password</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="submit-signup"></label>
					<div class="col-md-4">
						<button id="submit-signup" name="submit-signup" class="btn btn-primary">Sign Up</button>
					</div>
				</div>
			</fieldset>
		</form>
	</section>
</div>
@stop