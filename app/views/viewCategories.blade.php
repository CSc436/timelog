@extends('layout')
@section('header')
	<link href="{{ URL::asset('css/jquery.collapsibleList.css') }}" rel="stylesheet"/>
	<link href="{{ URL::asset('css/spectrum.css') }}" rel="stylesheet"/>
	<script src="{{ URL::asset('js/spectrum.js') }}"></script>
	<script src="{{ URL::asset('js/moment.min.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.collapsibleList.js') }}"></script>
	<script src="{{ URL::asset('js/sorttable.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.raty.min.js') }}"></script>
	<link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
	<script src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>
@stop
@section('content')
	
	<script type = "text/javascript">
		$(function(){
			$(".collapsible").collapsibleList();
		});
	</script>
	<div class="container" id="main">

	<h2 class="title">Categories</h2>
	<div name="category" id="category">
	<ul class="collapsible collapsibleList" >
		<?php
			foreach ($categories as $entry)
			{
				if ($entry->isTask == 0){
					if ($entry->PID == NULL){
						echo ("<li>".$entry->name . " <i class=\"fa fa-pencil\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".$entry->CID."/modal'})\"></i>");
						subCategories($entry);
						echo("</li>");
					}
				}
			}

			function subCategories($parentCategory) {
				$id = Auth::user()->id;
				$subCats = DB::select("select * from log_category c where c.pid =  $parentCategory->CID");
				if ($subCats != NULL){
					echo("<ul>\n");
					foreach($subCats as $sub){

						if ($sub->isTask == 0){
							echo ("<li>".$sub->name. "<i class=\"fa fa-pencil\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".$sub->CID."/modal'})\"></i>");
							subCategories($sub);
							echo("</li>");
						}

						else{
							echo ("<li>" . $sub->name. "<i class=\"fa fa-pencil\" onclick=\"return $('#thisModal').modal({remote: '/log/editTask/".$sub->CID."/modal'})\"></i>");
							subCategories($sub);
							echo("</li>");
						}
					}
					echo("</ul>\n");
				}
		 	}
		?>
	</ul>
	</div>
	<h2 class="title"> Overdue Tasks </h2>
	<div name="tasks" id="tasks">
		<table class="sortable table table-striped table-hover table-condensed">
			<tr>
				<th> TaskName  </th>
				<th> Deadline  </th>
				<th> Completed? </th>
				<th> Grade    </th>
			</tr>
			<?php
				foreach ($categories as $entry)
				{
					if ($entry->isTask == 1 && $entry->isCompleted ==0 && $entry->deadline <= new DateTime ) {
						echo ("<tr><td>".$entry->name."</td>");
						echo ("<td>". $entry->deadline ."</td>");
						if ($entry->isCompleted == 1){
							echo ("<td> yes </td>");
							echo ("<td>". $entry->rating ."</td>");
						}
						else {
							echo ("<td> no </td>");
							echo ("<td> N/A </td>");
						}
						echo ("<td></td><td><i class=\"fa fa-pencil\" onclick=\"return $('#thisModal').modal({remote: '/log/editTask/".$entry->CID."/modal'})\"></i></td></tr>");
					}
				}
			?>
		</table>
	</div>
	<script>
		$(function() {
			$('body').on('hidden.bs.modal', '.modal', function () {
				$(this).removeData('bs.modal');
				$('#thisModal').html("");
			});
		});
	</script>

	</div>

@stop