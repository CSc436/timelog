@extends('layout')

@section('header')
<link href="{{ URL::asset('css/addCategory.css') }}" rel="stylesheet"/>
<link href="{{ URL::asset('css/spectrum.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/spectrum.js') }}"></script>
<script src="{{ URL::asset('js/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.raty.min.js') }}"></script>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>

@stop

@section('content')
	<div class="container" id="main">
	<h2 class="title">Edit settings</h2>

	{{-- Form::model($user, array('route' => 'user.edit', $user->id)) --}}
	{{ Form::model($user, ['method' => 'GET', 'route' => ['user.edit', $user->id], 'style' => 'max-width:500px', 'role' => 'form', 'class' => 'form-horizontal']) }}

	<div class="form-group">
		{{ Form::label('calendarID', 'Google Calendar ID', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group">
				{{Form::text('calendarId', null, array('class' => 'form-control'))}}
			</div>
		</div>
	</div>


	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			{{ Form::submit('Submit', array('class' => 'btn btn-default btn-primary')) }}
		</div>
	</div>

	{{ Form::close() }}
	
	</div>
@stop
