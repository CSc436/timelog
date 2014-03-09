@extends('layout')

@section('header')
<link href="{{ URL::asset('css/addCategory.css') }}" rel="stylesheet"/>
@stop

@section('content')
	<div class="container" id="main">
	<h2 class="title">Add A New Category</h2>
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
		  {{ Form::label('starRating', 'How would you rate your completion of this task on a 3 star scale (no stars if task is not completed, use the dropdown menu. The stars are not fully implemented).', array('class' => 'col-sm-4 control-label')) }}	  
		  <div class="col-sm-8">
	  		<span class="rating">
            	<span class="star" onclick="$('#myhidden').set('1')" ></span>
            	<span class="star"></span>
            	<span class="star"></span>
      		</span>
      		{{Form::select('starRating', array('0' => '0 stars','1' => '1 star (below average)', '2' => '2 stars(average)', '3' => '3  stars(above average)'), '0');}}
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