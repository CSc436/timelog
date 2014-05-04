@extends('layout')

@section('content')	
	<div class="container" id="main">

	<h2 class="title">View</h2>

	<div class="well">
		{{ Form::open(array('url' => 'log/view', 'method' => 'get', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'chart_options')) }}
		<div class="daterange pull-right" id="daterange"><i class="fa fa-calendar"></i> <span>{{ date('F d, Y', $startDT) }} - {{ date('F d, Y', $endDT) }}</span> <i class="fa fa-caret-down"></i></div>
		{{ Form::hidden('start', '2014-04-24', array('id' => 'daterange_start')) }}
		{{ Form::hidden('end', '2014-04-30', array('id' => 'daterange_end')) }}

		<script type="text/javascript">
			$(document).ready(function() {
			    $('#daterange').daterangepicker({
			    	ranges: {
						'Last 7 Days': [moment().subtract('days', 6), moment()],
						'Last 30 Days': [moment().subtract('days', 29), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
					},
					format: "YYYY-MM-DD",
					startDate: "{{date('Y-m-d', $startDT)}}",
					endDate: "{{date('Y-m-d', $endDT)}}"
			    },
			    function(start, end) {
					$('#daterange_start').val(start.format('YYYY-MM-DD'));
					$('#daterange_end').val(end.format('YYYY-MM-DD'));
					$('#chart_options').submit();
				});
			});
		</script>

		<p>&nbsp;</p>
		{{ Form::close() }}
	</div>

	<div id="mainChart" style="width:100%;height:400px"></div>

	{{ Form::open(array('url' => 'log/view', 'method' => 'get', 'role' => 'form', 'class' => 'form-horizontal')) }}
	{{ Form::select('category', $categories); }}
	{{ Form::submit('Submit',['class'=>'btn btn-default']) }}
	{{ Form::close() }}

	<select name="time" id="time" onchange="setData()">
		<option value="1">Days</option>
		<option value="2">Months</option>
		<option value="3">Years</option>
	</select>

	<div class="table-responsive"><table class="table table-striped table-condensed table-hover">
		<tr>
			<th> Name </th>
			<th> Date </th>
			<th> Time and Duration </th>
			<th colspan="2"> Notes </th>
		</tr>

	<?php
		$toPlot = array();
		$toPlotSeries = array();
		foreach ($table_rows as $entries){
			$startDT = new DateTime($entries->startDateTime);
			$endDT = new DateTime($entries->endDateTime);
			echo ("<tr>");
			echo ("<td><div style=\"background-color: #{$entries->color};height: 1em;width: 1em;display:inline-block\"></div> {$entries->name}</td>");
			echo ("<td>{$startDT->format('D, m/d')}</td>");
			echo ("<td><strong>{$endDT->format('g:i a')}</strong> for {$entries->duration} minutes</td>");
			echo ("<td>{$entries->notes}</td><td><button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/edit/{$entries->LID}/modal'})\">Edit</button></td></tr>");
		}
		foreach ($chart_rows as $entries){
			// build JSON for chart data
			$startDT = new DateTime($entries->startDateTime);
			$toPlot[$entries->CID][] = array("Date.UTC({$startDT->format('Y, ')}".($startDT->format('m')-1)."{$startDT->format(', d')})", intval($entries->duration));
			if(!isset($toPlotSeries[$entries->CID])){
				$toPlotSeries[$entries->CID] = array(
					'name' => $entries->name,
					'color' => $entries->color
				);
			}
		}
		$seriesJson = '';
		foreach($toPlot as $thisCID => $thisData){
			if($seriesJson != '')
				$seriesJson .= ',';
			$seriesJson .= '{name:\''.str_replace('\'','\\\'',$toPlotSeries[$thisCID]['name']).'\',color:\'#'.$toPlotSeries[$thisCID]['color'].'\',data:'.preg_replace('/"(Date.UTC\((.*?)\))"/', '$1', json_encode($thisData)).'}';
		}
	?>
	</table></div>
	<script>
		$(function() {
			// empty model of old content when it closes (to allow for editting multiple items within one page load)
			$('body').on('hidden.bs.modal', '.modal', function () {
				$(this).removeData('bs.modal');
				$('#thisModal').html("");
			});

			// initialize mainChart
			$('#mainChart').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: null
				},
				xAxis: {
					type: 'datetime',
					startOnTick: true,
					endOnTick: true,
					tickInterval: 604800000, // 7 days in milliseconds
					tickWidth: 4,
					gridLineWidth: 1,
					gridLineDashStyle: "LongDash",
					minorTickInterval: 86400000, // 1 day in milliseconds
					minorTickWidth: 2,
					minorGridLineWidth: 0,
					labels: {
						formatter: function() { // only output a label Mondays
			            	if (new Date(this.value).getDay() == 0)
			                	 return Highcharts.dateFormat('%m/%d', this.value);
			                else
			                	return '';
			            }
			        },
			        plotBands: {
			        	from: <?= $todayStart ?>,
			        	to: <?= $todayEnd ?>,
			        	color: '#ddd',
			        	label: {
			        		text: 'Today',
			        		rotation: -90,
			        		x: 3,
			        		y: 25,
			                style: {
			                    "color": "#999"
			                }
			        	}
			        }
				},
				yAxis: {
					tickInterval: 60,
					labels: {
						formatter: function() { // only output a label Mondays
			            	return (this.value / 60) + " hr";
			            }
			        },
		            title: {
		                text: "Recorded Productivity",
		                style: {
		                    "color": "#444"
		                }
		            }
				},
				plotOptions: {
					column: {
                		stacking: 'normal',
                		groupPadding: null,
                		pointPadding: null,
                		pointRange: 86400000, // 1 day in milliseconds
                		borderWidth: 0
                	}
                },
				series: [<?= $seriesJson ?>]
	        });
		});
	</script>

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
				var time = document.getElementById("time").value;
				$.get("/api/log/data/" + cid + "/" + time, function(data){
					console.log(data);
					var obj = {key: "Your time logs", values: data};
					setupGraph([obj]);
				});
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
	</div>
<link href="{{ URL::asset('css/daterangepicker-bs3.css') }}" rel="stylesheet">
<script src="{{ URL::asset('js/highcharts.js') }}"></script>
<script src="{{ URL::asset('js/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/daterangepicker.js') }}"></script>

@stop