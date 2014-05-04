@extends('layout')
<?php if(!isset($message)) $message = ""; ?>

@section('header')
<link href="{{ URL::asset('css/addCategory.css') }}" rel="stylesheet"/>
<link href="{{ URL::asset('css/spectrum.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/spectrum.js') }}"></script>
<script src="{{ URL::asset('js/moment.min.js') }}"></script>
@stop

@section('content')
	<div class="container" id="main">
	<h2 class="title">Add A New Category</h2>
	<!-- 	<div class="alert alert-danger">
			<strong>Error:</strong>
			@if($message)
				echo ($message);
			@endif
		</div> -->

		{{ Form::open(array('url' => 'log/saveCat', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'style' => 'max-width:500px')) }}


	<div class="form-group">
		<div class="col-sm-8">
			{{ Form::hidden('isTask', '0') }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('categoryName', 'Category Name', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group">
				{{ Form::text('categoryName', '', array('id' => 'newcat', 'class' => 'form-control', 'placeholder' => 'New Category Name')) }}

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
		<div class="col-sm-offset-4 col-sm-8">
			{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
		</div>
	</div>
	{{ Form::close() }}
	
	</div>

	<script>
	$(function(){

		var $cats = $("#superCategory");

		window.getCategories = function(){
			var categories;
			$.getJSON("/api/log/categories", callBack);
		}

		function callBack(data){
			console.log(data);
			return
		}
		
		var categories = loadCategories();

		$.each(categories, function(k, v){
			$cats.append(new Option(v.name, v.cid));
		});

		/*
		$.getJSON("/api/log/categories", function(data){
			console.log(data);
			$.each(data, function(k, v){
				$cats.append(new Option(v.name, v.cid));
			});
		});*/

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