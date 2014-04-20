<div class="modal-dialog">
	<div class="modal-content">
		@if(!isset($editThis))
			{{ Form::open(array('url' => 'log/saveCat', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
		@else
			{{ Form::model($editThis, array('url' => 'log/updateCat/'.$editThis->CID, 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
		@endif
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="thisModalLabel">
					@if(!isset($editThis))
						Add A Category
					@else
						Edit Category
					@endif
				</h4>
			</div>
			<div class="modal-body">
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
				<div class="form-group">
					{{ Form::label('categoryName', 'What Category is this?', array('class' => 'col-sm-4 control-label')) }}
					<div class="col-sm-8">
						@if(!isset($editThis))
							{{ Form::text('categoryName', 'Not Used Yet', array('class' => 'form-control', 'placeholder' => 'Name')) }}
						@else
							{{ Form::text('categoryName', "$editThis->name", array('class' => 'form-control', 'placeholder' => 'Name')) }}
						@endif
					</div>
				  </div>
				  <div class="form-group">
					{{ Form::label('superCategory', 'Is this a sub-category? If so, put the parent Category here.', array('class' => 'col-sm-4 control-label')) }}
					<div class="col-sm-8">
						@if (!isset($editThis))
							{{ Form::text('subCategory', 'Not Used Yet', array('class' => 'form-control', 'placeholder' => 'Name')) }}
						@else
							{{ $PName = DB::table('log_category')->where('CID', $editThis->PID)->pluck('name')}}
							{{ Form::text('subCategory', "$PName", array('class' => 'form-control')) }}
						@endif
					</div>
				  </div>
				  <div class="form-group">
					{{ Form::label('isTask', 'Is this a task with a set deadline?', array('class' => 'col-sm-4 control-label')) }}
					<div class="col-sm-8">
						@if (!isset($editThis))
							{{ Form::checkbox('isTask', null, array('class' => 'form-control')) }}
						@else
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{{ Form::submit('Submit', array('class' => 'btn btn-default btn-primary')) }}
			</div>
		{{ Form::close() }}
	</div>
</div>