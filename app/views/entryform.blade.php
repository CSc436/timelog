@extends('layout')

@section('header')
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
@stop


@section('content')

	<div class="container" id="main">

	<h2 class="title">Add New Time Entry</h2>
	@if(!$errors->isEmpty())
		<div class="alert alert-danger">
			<strong>Error:</strong>
			@if($errors->count() == 1)
				{{{ $errors->first() }}}
			@else
				<ul>
					@foreach($errors->getMessages() as $msg)
						<li>{{{ $msg[0] }}}</li>
					@endforeach
				</ul>
			@endif
		</div>
	@endif

	@if(!isset($editThis))
		{{ Form::open(array('url' => 'log/save', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'style' => 'max-width:500px')) }}
	@else
		{{ Form::model($editThis, array('url' => 'log/save/'.$editThis->LID, 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal', 'style' => 'max-width:500px')) }}
	@endif
	  <div class="form-group">
		{{ Form::label('entryname', 'What will you be recording?', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::text('entryname', 'Not Used Yet', array('class' => 'form-control', 'placeholder' => 'Name')) }}
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('startDateTime', 'Start', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::text('startDateTime', null, array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd hh:mm')) }}
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('endDateTime', 'End', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::text('endDateTime', null, array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd hh:mm')) }}
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('category', 'Category', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::select('category', array(), null, array('class' => 'form-control')) }}
			<i class="fa fa-plus-circle"></i> Add a new category
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('notes', 'Notes', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::textarea('notes', null, array('class' => 'form-control')) }}
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
		</div>
	</div>
	{{ Form::close() }}
	
	</div>

	<!-- At this point I am not sure where to put the JS code to populate the category box -->
	<script>

		$(function(){

			// set default values for start and end dates
			// default date format: yyyy-mm-dd hh:mm

			var i = 0;
			var currDate = new Date();
			
			$("input[id$=DateTime]").each(function(k, v){

				var mins = currDate.getMinutes();
				var addMins = mins + (i++) * 15;
				currDate.setMinutes(addMins);
				$(v).val(moment(currDate).format('YYYY-MM-DD hh:mm'));

			});

			var $cats = $("#category");

			$.getJSON("/api/log/categories", function(data){
				console.log(data);
				$.each(data, function(k, v){
					$cats.append(new Option(v.name, v.name));
				});
				
			});

		});
	</script>
	
@stop