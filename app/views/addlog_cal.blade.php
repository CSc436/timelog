@extends('layout')

@section('header')
	<link href="{{ URL::asset('css/fullcalendar.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/fullcalendar.print.css') }}" rel="stylesheet" media='print' />
	<link href="{{ URL::asset('css/spectrum.css') }}" rel="stylesheet"/>
	<script data-main="{{ URL::asset('js/addlog_cal_main') }}" src="{{ URL::asset('js/require.js') }}"></script>
<!--
	<script src="http://fuelcdn.com/fuelux/2.3/loader.min.js"></script>
	<script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
	<script src="{{ URL::asset('js/fullcalendar_jso.js') }}"></script>
	<script src="{{ URL::asset('js/addlog_cal.js') }}"></script>
	<script src="{{ URL::asset('js/spectrum.js') }}"></script>
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
-->
@stop

@section('content')

	<div class="container" id="main">

		<h2 class="title">Calendar View</h2>
		<div id='calendar'></div>

	</div>
	
@stop
