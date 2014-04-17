@extends('layout')

@section('header')
<link href="{{ URL::asset('css/spectrum.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/spectrum.js') }}"></script>
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
		{{ Form::label('category', 'What will you be recording?', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group">
				{{Form::select('category', array('0' => ''), 'NULL', array('id' => 'category', 'class' => 'form-control'));}}
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="$('#newcatbox').toggle();$('#newcat').focus();"><span class="fa fa-plus"></span></button>
				</span>
			</div>
			<div class="input-group" style="display:none;margin-top:1em" id="newcatbox">
				{{ Form::text('newcat', '', array('id' => 'newcat', 'class' => 'form-control', 'placeholder' => 'New Category Name')) }}
				<span class="input-group-btn">
					<button id="colorPicker" class="btn btn-default" type="button"><span id="colorPickerIcon" class="fa fa-tint"></span></button>
				</span>
				{{ Form::text('color', '', array('id' => 'color', 'class' => 'form-control', 'placeholder' => '#CCCCCC')) }}
			</div>
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('startDateTime', 'Start', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group">
				{{ Form::text('startDateTime', null, array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd hh:mm')) }}
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="var d = new Date();$('#startDateTime').val(d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes());">Now</button>
				</span>
			</div>
		</div>
	  </div>
	  <div class="form-group">
		{{ Form::label('endDateTime', 'End', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group">
				{{ Form::text('endDateTime', null, array('class' => 'form-control', 'placeholder' => 'yyyy-mm-dd hh:mm')) }}
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="var d = new Date();$('#endDateTime').val(d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes());">Now</button>
				</span>
			</div>
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

	<script>

		$(function(){

			$("#colorPicker").spectrum({
			    color: getRandomColor(),
			    change: function(color) {
 					console.log(color.toHex()); // #ff0000
 					$("#color").val(color.toHex());
				}
			});

			// set default values for start and end dates
			// default date format: yyyy-mm-dd hh:mm

			var i = 0;
			var currDate = new Date();
			
			$("input[id$=DateTime]").each(function(k, v){

				var mins = currDate.getMinutes();
				var addMins = mins + (i++) * 15;
				currDate.setMinutes(addMins);
				$(v).val(moment(currDate).format('YYYY-MM-DD HH:mm'));

			});

			var $cats = $("#category");

			$.getJSON("/api/log/categories", function(data){
				console.log(data);
				$.each(data, function(k, v){
					$cats.append(new Option(v.name, v.cid));
				});
				
			});

		});

		function getRandomColor(){
			return "#"+((Math.random() * (0xffffff)) << 0).toString(16);
		}

	</script>
	
@stop