@extends('layout')

@section('content')	
	<link href="{{ URL::asset('js/sorttable.js') }}" rel="text/javascript">
	<script src="{{ URL::asset('js/sorttable.js') }}"></script>
	<script type = "text/javascript">
		function viewSubcat(cid) {
			console.log(cid);
			var item = document.getElementsByClassName(cid)[0];
			console.log(item);
			if(item) {
				$("."+cid).toggle('2000', 'swing', function(){
					//childs = $(item).child().style;
					//console.log(childs);
				});
			}
		}
	</script>
	<div class="container" id="main">

	<h2 class="title">Categories</h2>
	<div name="category" id="category">
	<ul class="list sortable" >
		<?php
			foreach ($categories as $entries)
			{
				if ($entries->isTask == 0){
					if ($entries->PID == NULL){
						echo ("<li onclick = viewSubcat($entries->CID)>".$entries->name. "<button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".$entries->CID."/modal'})\">Edit</button></li>\n");
						subCategories($entries);
					}
				}
			}

			function subCategories($parentCategory) {
		 	$id = Auth::user()->id;
		 	$subCats = DB::select("select * from log_category c where c.pid =  $parentCategory->CID");
		 	if ($subCats != NULL){

		 		echo("<ul class = 'subcat'>\n");
				if ($subCats != NULL) {
				}
				foreach($subCats as $sub){
					echo ("<li class = 'subcat $parentCategory->CID' onclick = viewSubcat($sub->CID) style = 'display:none'>" . $sub->name . "<button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".$sub->CID."/modal'})\">Edit</button></li>\n");
					subCategories($sub);
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
				foreach ($categories as $entries)
				{
					if ($entries->isTask == 1) {
						echo ("<tr><td>".$entries->name."</td>");
						echo ("<td>". $entries->deadline ."</td>");
						if ($entries->isCompleted == 1){
							echo ("<td> yes </td>");
							echo ("<td>". $entries->rating ."</td>");
						}
						else {
							echo ("<td> no </td>");
							echo ("<td> N/A </td>");
						}
						
						echo ("<td></td><td><button class=\"btn btn-xs\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".$entries->CID."/modal'})\">Edit</button></td></tr>");
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