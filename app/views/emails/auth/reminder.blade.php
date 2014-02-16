@extends('emails.auth.email')

@section('content')
	<h2 class="title">Time Log Password Reset</h2>
	<div>
		A password reset for your Time Log account was requested by you (hopefully). To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.
	</div>
@stop