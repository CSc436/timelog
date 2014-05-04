@extends('layout')

@section('header')
<link href="{{ URL::asset('css/addCategory.css') }}" rel="stylesheet"/>
<link href="{{ URL::asset('css/spectrum.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/spectrum.js') }}"></script>
<script src="{{ URL::asset('js/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.raty.min.js') }}"></script>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>

@stop

@section('content')
	<div class="container" id="main">
	<h2 class="title">Add A New Task</h2>
	@if(!$errors->isEmpty())
		<div class="alert alert-danger">
			<strong>Error:</strong>
			@if($errors->count() == 1)
				{{ $errors->first() }}
			@else
				<ul>
					@foreach($errors->getMessages() as $msg)
						<li>{{ $msg[0] }}</li>
					@endforeach
				</ul>
			@endif
		</div>
	@endif

		{{ Form::open(array('url' => 'log/saveCat', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'style' => 'max-width:500px')) }}

	<div class="form-group">
		<div class="col-sm-8">
			{{ Form::hidden('isTask', '1') }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('categoryName', 'Task Name', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group">
				{{ Form::text('categoryName', '', array('id' => 'newcat', 'class' => 'form-control', 'placeholder' => 'New Task Name')) }}

				<span class="input-group-btn">
					<button id="colorPicker" class="btn btn-default" type="button"><span id="colorPickerIcon" class="fa fa-tint"></span></button>
				</span>
				{{ Form::hidden('color', '', array('id' => 'color', 'class' => 'form-control', 'placeholder' => 'FFFFFF')) }}
			</div>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('superCategory', 'Parent Category', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{Form::select('superCategory', array('0' => ''), 'NULL', array('id' => 'superCategory', 'class' => 'form-control'));}}
		</div>
	</div>
	  

	<div class="form-group">
		{{ Form::label('hasDuedate', 'Has Due Date', array('class' => 'col-sm-4 control-label')) }}	  
		<div class="col-sm-8">
			{{ Form::checkbox('hasDuedate') }}
		</div>
	</div>

	<div class="form-group" id="duedate-form">
		{{ Form::label('dueDateTime', 'Due Date', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group date">

					<span id='datetimepickerDue'>
						{{ Form::text('dueDateTime', null, array('class' => 'form-control')) }}
					</span>

					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="var d = new Date();$('#dueDateTime').val(moment(d).format('MM/DD/YYYY hh:mm A'));">Now</button>
					</span>

			</div>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('completed', 'Completed', array('class' => 'col-sm-4 control-label')) }}	  
		<div class="col-sm-8">
			{{ Form::checkbox('isCompleted') }}
		</div>
	</div>

	<div class="form-group" id="star-form">
		{{ Form::label('starRating', 'Rate Your Productivity', array('class' => 'col-sm-4 control-label')) }}	  
		<div class="col-sm-8">
			<div id="starRatingDiv" data-number="3"></div>
			{{ Form::hidden('starRating') }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
		</div>
	</div>
	{{ Form::close() }}
	
	</div>

	<script>
	$(function(){

		$(document).on('submit', 'form', function(e) {
			var databaseDueTimeStirng = convertToDatabaseTime( $("#dueDateTime").val() );
			$("#dueDateTime").val(databaseDueTimeStirng);
		});

		function convertToDatabaseTime(usTime){
			console.log(usTime);
			return moment(usTime, 'MM/DD/YYYY hh:mm A').format("YYYY-MM-DD HH:mm");
		}

		$("#star-form").toggle($('#isCompleted').checked);
		$('[name = isCompleted]').click(function() {
			console.log("toggle");
			$("#star-form").fadeToggle(this.checked);
		}); 

		$("#duedate-form").toggle($('#hasDuedate').checked);
		$('[name = hasDuedate]').click(function() {
			console.log("toggle");
			$("#duedate-form").fadeToggle(this.checked);
		}); 

		var $cats = $("#superCategory");

		$.getJSON("/api/log/categories", function(data){
			console.log(data);
			$.each(data, function(k, v){
				$cats.append(new Option(v.name, v.cid));
			});
		});

		$("#datetimepickerDue").datetimepicker({
			language: 'en'
		});

		$("#starRatingDiv").raty({
			starOff : '/image/star-off.png',
			starOn  : '/image/star-on.png',
			cancelOff : '/image/cancel-custom-off.png',
			cancelOn : '/image/cancel-custom-on.png',
			number: function() {
				return $(this).attr('data-number');
			},
			size: 24,
			cancel:true,
			click: function(score, evt) {
    			$("#starRating").val(score);
    			console.log("rating");
  			}
		});


		function initializeColorPicker(){
			$("#colorPicker").spectrum({
				color: "rgb(255, 255, 255)",
				showPalette: true,
				palette: [
					["rgb(255, 255, 255)", "rgb(221, 126, 107)", "rgb(234, 153, 153)"], 
					["rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(202, 235, 188)"],
					["rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)"], 
					["rgb(180, 167, 214)", "rgb(213, 166, 189)", "rgb(235, 137, 234)"]
				],
				change: function(color) {
					$("#newcat").css('background-color', color.toHexString());
					$("#color").val(color.toHex());
				}
			});

			var defaultColor = "ffffff";
			$("#color").val(defaultColor);
			$("#newcat").css('background-color', "#" + defaultColor);
		}
	
		initializeColorPicker();
	});
	</script>

@stop
