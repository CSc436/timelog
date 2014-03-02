@extends('layout')

@section('header')
	<link href="{{ URL::asset('css/fullcalendar.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/fullcalendar.print.css') }}" rel="stylesheet" media='print' />
	<script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
	<script src="{{ URL::asset('js/fullcalendar.min.js') }}"></script>
	<script src="{{ URL::asset('js/addlog_cal.js') }}"></script>
@stop

@section('content')
	<h2 class="title">Add New Time Entry(only adding allowed, each edit currently counts as a add)</h2>
	<div id='calendar'></div>
	
@stop