@extends('layout')

@section('content')
	<h2 class="title">Add New Time Entry</h2>
	
	<form method="post" action="/log/add" role="form" class="form-horizontal" style="max-width:500px">
	  <div class="form-group">
		<label for="entryname" class="col-sm-4 control-label">What will you be recording?</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="entryname" name="entryname" placeholder="Name">
		</div>
	  </div>
	  <div class="form-group">
		<label for="startDateTime" class="col-sm-4 control-label">Start</label>
		<div class="col-sm-8">
			<input type="datetime" class="form-control" id="startDateTime" name="startDateTime" placeholder="yyyy-mm-dd hh:mm">
		</div>
	  </div>
	  <div class="form-group">
		<label for="endDateTime" class="col-sm-4 control-label">End</label>
		<div class="col-sm-8">
			<input type="datetime" class="form-control" id="endDateTime" name="endDateTime" placeholder="yyyy-mm-dd hh:mm">
		</div>
	  </div>
	  <div class="form-group">
		<label for="category" class="col-sm-4 control-label">Category</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="category" name="category">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-default">Submit</button>
		</div>
	</div>
	</form>
	
	
@stop