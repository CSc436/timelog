@extends('layout')

@section('content')	
	<link href="{{ URL::asset('js/sorttable.js') }}" rel="text/javascript">
	<script src="{{ URL::asset('js/sorttable.js') }}"></script>
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
			/*table-layout: fixed;*/
			width: 80%;
			padding: 1px;
		}
		tr .colorBox {
			border: solid black 1px;
			height: 10px;
			width: 10px;
		}
	</style>
	<script>
		window.onload = function() {
			/* Pie Graph */
			$.get("/api/log/pie", function(pieData) {
				if(pieData) {
					var customColors = [];

					for(var i = 0; i < pieData.length; i++) {
						customColors.push(pieData[i].color);
					}

					setupPieGraph(pieData, customColors);
				} else {
					$("#pie").html("<h2>No data</h2>");
				}
			});

			function setupPieGraph(pieData, customColors) {
				nv.addGraph(function() {
					var chart = nv.models.pieChart()
						.x(function(d) { return d.label })
						.y(function(d) { return ((+d.value)/60) })
						.color(customColors)
						.showLabels(true)
						.labelType("percent");
						;
				 
					d3.select('#pie svg')
						.datum(pieData)
						.transition().duration(350)
						.call(chart);
				 
				 	console.log(customColors);
					return chart;
				});
			}

			/* Bar Graph */
		
			window.setData = function() {
				var cid = document.getElementById("category").value;
				if(cid == "-----") {
					$.get("/api/log/data", function(data){
						var obj = {key: "Your time logs", values: data};
						setupGraph([obj]);
					});
				} else {
					$.get("/api/log/category/" + cid, function(data){
						console.log(data);
						var obj = {key: "Your time logs", values: data};
						setupGraph([obj]);
					});
				}
			}

			setData();

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
	<?php echo $input[1]; ?>
	<div id="pie">
		<svg></svg>
	</div>

	<select name="category" id="category" onchange="setData()">
		<option value="-----">-----</option>
		<?php
			foreach ($categories as $names)
			{
				echo ("<option value=".$names->cid.">".$names->name."</option>");
			}
		?>
	</select>
	<div id="chart">
		<svg></svg>
	</div>

	{{ Form::open(array('url' => 'log/view', 'method' => 'get', 'role' => 'form')) }}
	{{ Form::select('dates', $dates); }}
	{{ Form::submit('Submit',['class'=>'btn btn-default']) }}
	{{ Form::close() }}

	<table class="sortable" id="removable">
		<tr>
			<?php
				if(property_exists($query[0], "name")) {
					echo ("<th> </th>");
					echo ("<th> Name </th>");
				}
			?>
			<th> Start Date </th>
			<th> End Date </th>
			<th> Duration </th>
			<th> Notes </th>
		</tr>

	<?php
		foreach ($query as $entries)
		{
			if(property_exists($entries, "name")) {
				echo ("<tr><td>"."<div class="."\"colorBox\""."style="."\"background-color: #$entries->color\">"."</div>"."</td>");
				echo ("<td>".$entries->name."</td>");
				echo ("<td>".$entries->startDateTime."</td>");
			} else {
				echo ("<tr><td>".$entries->startDateTime."</td>");
			}
			echo ("<td>".$entries->endDateTime."</td>");
			echo ("<td>".$entries->duration."</td>");
			echo ("<td>".$entries->notes."</td><td><button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/edit/".$entries->LID."/modal'})\">Edit</button></td></tr>");
		}
	?>
	</table>
</div>
	<?php echo $query->links(); ?>
	<script>
		$(function() {
			$('body').on('hidden.bs.modal', '.modal', function () {
				$(this).removeData('bs.modal');
				$('#thisModal').html("");
			});
		});
	</script>

	</div>

@stop