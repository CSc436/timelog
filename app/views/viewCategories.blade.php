@extends('layout')
@section('header')
	<link href="{{ URL::asset('css/jquery.collapsibleList.css') }}" rel="stylesheet"/>
	<script src="{{ URL::asset('js/jquery.collapsibleList.js') }}"></script>
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
	<ul class="collapsible" >
		<?php
			foreach ($categories as $entry)
			{
				if ($entry->isTask == 0){
					if ($entry->PID == NULL){
						echo ("<li>".$entry->name. "<button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".$entry->CID."/modal'})\">Edit</button>");
						subCategories($entry);
						echo("</li>");
					}
				}
			}

			function subCategories($parentCategory) {
				$id = Auth::user()->id;
				$subCats = DB::select("select * from log_category c where c.pid =  $parentCategory->CID");
				if ($subCats != NULL){
					echo("<ul>");
					foreach($subCats as $sub){
						echo ("<li>" . $sub->name. "<button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".$sub->CID."/modal'})\">Edit</button>");
						subCategories($sub);
						echo("</li>");
					
					}
					echo("</ul>\n");
				}
		 	}
		

		?>
	</ul>
	</div>
	<h2 class="title"> Tasks </h2>
	<div name="tasks" id="tasks">
		<table class="sortable">
			<tr>
				<th> TaskName  </th>
				<th> Deadline  </th>
				<th> Completed? </th>
				<th> Grade    </th>
			</tr>
			<?php
				foreach ($categories as $entry)
				{
					if ($entry->isTask == 1) {
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
						echo ("<td></td><td><button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/edit/".$entry->CID."/modal'})\">Edit</button></td></tr>");
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