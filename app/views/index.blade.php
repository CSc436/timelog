@extends('layout')

@section('content')

	@if(Auth::check())
		{{ View::make('index_user') }}
	@else
		{{ View::make('index_guest') }}
	@endif

@stop