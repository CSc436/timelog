@extends('layout')

@section('content')
	<h2 class="title">Home</h2>
	{{ Session::get("success") }}

	<div class="jumbotron">
	  <h1>Welcome to Time Log</h1>
	  <p>Time Log makes it really easy to log your tasks and help you plan your tasks effortlessly. The use of Time Log guarantees you with maximum productivity and minimum stress. You can order this program with 3 easy payments of $19.99. Order now and get a free Time Log sticker, a $4.99 value!</p>
	</div>

@stop