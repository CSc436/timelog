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
				<div class="col-sm-8">
					{{ Form::hidden('isTask', '0') }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('categoryName', 'Category Name', array('class' => 'col-sm-4 control-label')) }}
				<div class="col-sm-8">
					<div class="input-group">
						@if(!isset($editThis))
							{{ Form::text('categoryName', 'Not Used Yet', array('id' => 'newcat', 'class' => 'form-control', 'placeholder' => 'Name')) }}
						@else
							{{ Form::text('categoryName', "$editThis->name", array('id' => 'newcat', 'style' => "background-color: #$editThis->color", 'class' => 'form-control', 'placeholder' => 'Name')) }}
						@endif
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
	</div>
</div>

<script>
	$(function(){

		var $cats = $("#superCategory");

		$.getJSON("/api/log/categories", function(data){
			console.log(data);
			$.each(data, function(k, v){
				$cats.append(new Option(v.name, v.cid));
			});
			
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