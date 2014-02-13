@extends('layout')

@section('content')
	<h2 class="title">Contact</h2>
	
	<?php $arr = array("Haily De La Cruz" => "haily@email.arizona.edu",
	"Gopal Adhikari" => "gopala@email.arizona.edu",
	"Zuoming Shi" => "zuomingshi@email.arizona.edu",
	"Victor Nguyen" => "victornguyen@email.arizona.edu",
	"Michael Knatz" => "michaelcknatz@email.arizona.edu",
	"James Yoshida" => "yoshida@email.arizona.edu"); ?>
	
	<table class="table table-striped">
	@foreach($arr as $key => $value)
		<tr>
		<td class="name">{{ $key }}</td>
		<td class="email">{{ $value }}</td>
		<td class="member">Development Team</td>
		</tr>
	@endforeach
	</table>
	
	<style scoped>
	.email{
		color: blue;
		font-size: 20px;
	}
	.name{
		font-weight: bold;
		font-size: 20px;
	}
	.member{
		font-style: italic;
		font-size: 20px;
	}
	</style>
@stop