@extends('layout')
<?php if(!isset($message)) $message = ""; ?>

@section('header')
<link href="{{ URL::asset('css/addCategory.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/jquery.raty.min.js') }}"></script>
<script>
	
	$(function(){
		$("#starRating").raty({
			starOff : '/image/star-off.png',
  			starOn  : '/image/star-on.png',
  			cancelOff : '/image/cancel-custom-off.png',
  			cancelOn : '/image/cancel-custom-on.png',
  			number: function() {
			    return $(this).attr('data-number');
			},
			size: 24,
			cancel:true
		});
	});

</script>
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
		{{ Form::label('categoryName', 'What Category is this?', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::text('categoryName', 'Not Used Yet', array('class' => 'form-control', 'placeholder' => 'Name')) }}
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('superCategory', 'Is this a sub-category? If so, put the parent Category here.', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::text('superCategory', null, array('class' => 'form-control')) }}
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('isTask', 'Is this a task with a set deadline?', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::checkbox('isTask', null, array('class' => 'form-control')) }}
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('taskDeadline', 'If this is a task, when is it due?', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::text('taskDeadline', null, array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd hh:mm')) }}
		</div>
	  </div>
	  <div class="form-group">
		  {{ Form::label('starRating', 'How would you rate your completion of this task on a 3 star scale', array('class' => 'col-sm-4 control-label')) }}	  
		  <div class="col-sm-8">
		  	<div id="starRating" data-number="3"></div>
      	  </div>
      </div>
	  <div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
		</div>
	</div>
	{{ Form::close() }}
	
	</div>
@stop