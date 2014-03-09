@extends('layout')

@section('header')
	<link href="{{ URL::asset('css/fullcalendar.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/fullcalendar.print.css') }}" rel="stylesheet" media='print' />
	<script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
	<script src="{{ URL::asset('js/fullcalendar.min.js') }}"></script>
	<script src="{{ URL::asset('js/addlog_cal.js') }}"></script>
@stop

@section('content')

	<div class="container" id="main">

		<h2 class="title">Manage your entries</h2>
		<div id='calendar'></div>

	</div>
	
@stop

