@extends('layout')

@section('content')
	<h2 class="title">View</h2>
	<style>
		table {
			table-layout: fixed;
			width: 80%;
			padding: 1px;
		}
	</style>

	<table>
		<tr>
			<th> Start Date </th>
			<th> End Date </th>
			<th> Duration </th>
			<th> Notes </th>
		</tr>
	<?php
		foreach ($query as $entries)
		{
   			echo ("<tr><td>".$entries->startDateTime."</td>");
   			echo ("<td>".$entries->endDateTime."</td>");
  			echo ("<td>".$entries->duration."</td>");
   			echo ("<td>".$entries->notes."</td></tr>");
		}
	?>
	</table>

@stop