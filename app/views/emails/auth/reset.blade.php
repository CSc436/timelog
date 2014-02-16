@extends('../../layout')

@section('content')

<h2 class="title">Reset Password</h2>

<form class="form-horizontal" id="password-reset-form" action="{{ action('RemindersController@postReset') }}" method="post">
	<fieldset>

		<input type="hidden" name="token" value="{{ $token }}" class="form-control input-md" required>

		<div class="form-group">
			<label class="col-md-4 control-label" for="email">Email</label>
			<div class="col-md-5">
				<input type="email" name="email" id="email" class="form-control input-md" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label" for="password">New Password</label>
			<div class="col-md-5">
				<input type="password" name="password" id="password" class="form-control input-md" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label" for="password_confirmation">Confirm Password</label>
			<div class="col-md-5">
				<input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-md" required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label" for="submit-signup"></label>
			<div class="col-md-4">
				<button type="submit" class="btn btn-primary">Reset Password</button>
			</div>
		</div>
	</fieldset>
</form>

@stop