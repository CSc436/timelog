@extends('layout')

@section('content')
	<h2 class="title">Home</h2>
	{{ Session::get("success") }}

@stop