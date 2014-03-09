@extends('layout')

@section('content')

	<div class="container" id="main">
		<h1>404 - Not Found</h1>
		<p>The requested page was not found in the server. Sorry.</p>
		<a href="{{ URL::action('PagesController@Index')}}">Go back to the home page</a>
	</div>

@stop