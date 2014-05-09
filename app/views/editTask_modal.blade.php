@section('header')
<link href="{{ URL::asset('css/addCategory.css') }}" rel="stylesheet"/>
@stop

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
						Add A Task
					@else
						Edit Task
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
	<div class="form-group">
		<div class="col-sm-8">
			{{ Form::hidden('isTask', '1') }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('categoryName', 'Task Name', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group">
				{{ Form::text('categoryName', "$editThis->name", array('id' => 'newcat', 'style' => "background-color: #$editThis->color", 'class' => 'form-control')) }}

				<span class="input-group-btn">
					<button id="colorPicker" class="btn btn-default" type="button"><span id="colorPickerIcon" class="fa fa-tint"></span></button>
				</span>
				{{ Form::hidden('color', '', array('id' => 'color', 'class' => 'form-control', 'placeholder' => "$editThis->color")) }}
			</div>
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('superCategory', 'Parent Category', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::select('superCategory', array('0' => ''), 'null',  array('id' => 'superCategory', 'class' => 'form-control'));}}
		</div>
	</div>
	  

	<div class="form-group">
		{{ Form::label('hasDuedate', 'Has Duedate', array('class' => 'col-sm-4 control-label')) }}	  
		<div class="col-sm-8">
			{{ Form::checkbox('hasDuedate') }}
		</div>
	</div>

	<div class="form-group" id="duedate-form">
		{{ Form::label('dueDateTime', 'Duedate', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group date">

					<span id='datetimepickerDue'>
						{{ Form::text('dueDateTime', "$editThis->deadline", array('class' => 'form-control')) }}
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
	</div>
	</div>
</div>

<script>
	$(function(){

		$(document).on('submit', 'form', function(e) {
			var databaseDueTimeStirng = convertToDatabaseTime( $("#dueDateTime").val() );
			$("#dueDateTime").val(databaseDueTimeStirng);
		});

		if($("#dueDateTime").val() != null)
			var formTimeString = convertToSiteTime($("#dueDateTime").val());
			$("#dueDateTime").val(formTimeString);

		function convertToDatabaseTime(usTime){
			console.log(usTime);
			return moment(usTime, 'MM/DD/YYYY hh:mm A').format("YYYY-MM-DD HH:mm");
		}

		function convertToSiteTime(dbTime){
			console.log(dbTime);
			console.log(moment(dbTime, 'YYYY-MM-DD hh:mm').format("MM/DD/YYYY hh:mm A"));
			return moment(dbTime, 'YYYY-MM-DD hh:mm').format("MM/DD/YYYY hh:mm A");
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

		var defaultSuperCategory = "<?php echo $editThis->PID; ?>";

		$.getJSON("/api/log/categories", function(data){
			console.log(data);
			$.each(data, function(k, v){
				$cats.append(new Option(v.name, v.cid, v.cid == defaultSuperCategory , v.cid == defaultSuperCategory));
			});
			
		});
		//$('#superCategory[value="' + defaultSuperCategory + '"]').prop('selected', true);

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
		}
	
		initializeColorPicker();
	});
</script>