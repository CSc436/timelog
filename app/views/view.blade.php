@extends('layout')

@section('content')	
	<div class="container" id="main">

	<h2 class="title">View</h2>
	<div id="mainChart" style="width:100%;height:400px"></div>
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
		foreach ($query as $entries)
		{
			$startDT = new DateTime($entries->startDateTime);
			$endDT = new DateTime($entries->endDateTime);
			echo ("<tr>");
			echo ("<td><div style=\"background-color: #{$entries->color};height: 1em;width: 1em;display:inline-block\"></div> {$entries->name}</td>");
			echo ("<td>{$startDT->format('D, m/d')}</td>");
			echo ("<td><strong>{$endDT->format('g:i a')}</strong> for {$entries->duration} minutes</td>");
			echo ("<td>{$entries->notes}</td><td><button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/edit/{$entries->LID}/modal'})\">Edit</button></td></tr>");

			// build JSON for chart data
			if(!isset($toPlotSeries[$entries->CID])){
				$toPlot[$entries->CID][] = array("Date.UTC({$startDT->format('Y, ')}".($startDT->format('m')-1)."{$startDT->format(', d')})", $entries->duration);
				$toPlotSeries[$entries->CID] = array(
					'name' => $entries->name,
					'color' => $entries->color,
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
					type: 'column',
					ignoreHiddenSeries: false
				},
				title: {
					text: null
				},
				xAxis: {
					type: 'datetime',
					tickInterval: 86400000,
					startOnTick: true,
					endOnTick: true,
					labels: {
						formatter: function() { // only output a label Mondays
			            	if (new Date(this.value).getDay() == 0)
			                	 return Highcharts.dateFormat('%m/%d', this.value);
			                else
			                	return null;
			            }
			        }
				},
				plotOptions: {
					column: {
                		stacking: 'normal',
                		groupPadding: null,
                		pointPadding: null
                	}
                },
				series: [<?= $seriesJson ?>],
	        });
		});
	</script>

	</div>

@stop