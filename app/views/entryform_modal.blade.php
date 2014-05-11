<script src="{{ URL::asset('js/spectrum.js') }}"></script>
<link href="{{ URL::asset('css/spectrum.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.raty.min.js') }}"></script>
<link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
<script src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>

<div class="modal-dialog">
	<div class="modal-content">
		@if(!isset($editThis))
		{{ Form::open(array('url' => 'log/save', 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
		@else
		{{ Form::model($editThis, array('url' => 'log/save/'.$editThis->LID, 'method' => 'post', 'role' => 'form', 'class' => 'form-horizontal')) }}
		@endif
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="thisModalLabel">
				@if(!isset($editThis))
				Add New Time Entry
				@else
				Edit Time Entry
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
						{{ Form::hidden('color', '', array('id' => 'color', 'class' => 'form-control', 'placeholder' => '#CCCCCC')) }}
					</div>
				</div>
			</div>

	<div class="form-group">
		{{ Form::label('startDateTime', 'Start', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group date">
				    <span id='datetimepickerStart'>
				    	{{ Form::text('startDateTime', null, array('class' => 'form-control')) }}
				    </span>

					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="var d = new Date();$('#startDateTime').val(moment(d).format('MM/DD/YYYY hh:mm A'));">Now</button>
					</span>

			</div>
		</div>
	</div>

	  <div class="form-group">
		{{ Form::label('endDateTime', 'End', array('class' => 'col-sm-4 control-label')) }}
		<div class="col-sm-8">
			<div class="input-group date">
			    <span id='datetimepickerEnd'>
			    	{{ Form::text('endDateTime', null, array('class' => 'form-control')) }}
			    </span>

				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="var d = new Date();$('#endDateTime').val(moment(d).format('MM/DD/YYYY hh:mm A'));">Now</button>
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
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		{{ Form::close() }}
	</div>
</div>

	<script>

		$(function(){

			$(document).on('submit', 'form', function(e) {
				var databaseStartTimeStirng = convertToDatabaseTime( $("#startDateTime").val() );
				$("#startDateTime").val(databaseStartTimeStirng);
				var databaseEndTimeStirng = convertToDatabaseTime( $("#endDateTime").val() );
				$("#endDateTime").val(databaseEndTimeStirng);
			});

			$("#datetimepickerStart").datetimepicker({
    		    language: 'en'
    		});

			$("#datetimepickerEnd").datetimepicker({
    		    language: 'en'
    		});

			var i = 0;
			var currDate = new Date();
			
			$("input[id$=DateTime]").each(function(k, v){

				var mins = currDate.getMinutes();
				var addMins = mins + (i++) * 15;
				currDate.setMinutes(addMins);
				$(v).val(moment(currDate).format('MM/DD/YYYY hh:mm A'));

			});

			var $cats = $("#category");

			$.getJSON("/api/log/categories", function(data){
				console.log(data);
				$.each(data, function(k, v){
					$cats.append(new Option(v.name, v.cid));
				});
				
			});

			initializeColorPicker();
		});
		
		function convertToDatabaseTime(usTime){
			console.log(usTime);
			return moment(usTime, 'MM/DD/YYYY hh:mm A').format("YYYY-MM-DD HH:mm");
		}

		function initializeColorPicker(){
			$("#colorPicker").spectrum({
				color: "ee802a",
				showPalette: true,
				palette: [
					//["FFCC66", "FF4D4D", "rgb(234, 153, 153)"], 
					//["rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(202, 235, 188)"],
					//["rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)"], 
					//["rgb(180, 167, 214)", "rgb(213, 166, 189)", "rgb(235, 137, 234)"]
					["ee5555", "55ee55", "5555ee"], 
					["cccc55", "ee2a80", "80ee2a"],
					["2aee80", "802aee", "2a80ee"], 
					["55cccc", "cc55cc", "ee802a"]
				],
				change: function(color) {
					$("#newcat").css('background-color', color.toHexString());
					$("#color").val(color.toHex());
				}
			});

			var defaultColor = "ee802a";
			$("#color").val(defaultColor);
			$("#newcat").css('background-color', "#" + defaultColor);
		}

		function getRandomColor(){
			return "#"+((Math.random() * (0xffffff)) << 0).toString(16);
		}

	</script>