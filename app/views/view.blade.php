@extends('layout')

@section('content')
	<h2 class="title">View</h2>
	<style>
		#chart svg {
		  height: 400px;
		}

		table {
			table-layout: fixed;
			width: 80%;
			padding: 1px;
		}
	</style>
	<script>
		window.onload = function() {

			$.get("/api/log/view", function(data){
				var obj = {key: "Your time logs", values: data};
				setupGraph([obj]);
			});

			function setupGraph(data){

				nv.addGraph(function() {
				   	chart = nv.models.discreteBarChart()
					  .x(function(d) { return d.label })    //Specify the data accessors.
					  .y(function(d) { return (+d.value) })
					  .staggerLabels(false)    //Too many bars and not enough room? Try staggering labels.
					  .tooltips(false)        //Don't show tooltips
					  .showValues(true)       //...instead, show the bar value right on top of each bar.
					  .transitionDuration(350)
					  ;
				 


					d3.select('#chart svg')
					  .datum(data)
					  .call(chart);
				 
				 	nv.utils.windowResize(chart.update);
				 
				  return chart;
				});

			}
		};

 
	</script>
	<div id="chart">
		<svg></svg>
	</div>

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