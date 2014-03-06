@extends('layout')

@section('content')

	<div class="container" id="main">

	<h2 class="title">View</h2>
	<style scoped>
		#chart svg {
		  height: 400px;
		}

		#pie svg {
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
			/* Pie Graph */
			$.get("/api/log/pie", function(pieData) {
				var customColors = [];

				for(var i = 0; i < pieData.length; i++) {
					customColors.push(pieData[i].color);
				}

				setupPieGraph(pieData, customColors);
			});

			function setupPieGraph(pieData, customColors) {
				nv.addGraph(function() {
					var chart = nv.models.pieChart()
						.x(function(d) { return d.label })
						.y(function(d) { return ((+d.value)/60)})
						.color(customColors)
						.showLabels(true);
				 
					d3.select('#pie svg')
						.datum(pieData)
						.transition().duration(350)
						.call(chart);
				 
					return chart;
				});
			}

			/* Bar Graph */
			$.get("/api/log/view", function(data){
				var obj = {key: "Your time logs", values: data};
				setupGraph([obj]);
			});


			function setupGraph(data) {

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
	<div id="pie">
		<svg></svg>
	</div>

	<div id="chart">
		<svg></svg>
	</div>

	<table class="table">
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

	</div>

@stop