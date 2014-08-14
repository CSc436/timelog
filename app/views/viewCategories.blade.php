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

	<h2 class="title">Edit categories</h2>
	<div name="category" id="category">
	<ul class="collapsible collapsibleList" >
		<?php
			foreach ($categories as $entry)
			{
				// if ($entry->isTask == 0){
					if ($entry->PID == NULL){
						//"<i class=\"fa fa-square\" color=#".$entry->color."></i>"
						echo ("<li>".
							"<span style=color:#".
							$entry->color.
							">".
							"<i class=\"fa fa-square\"></i>".
							"</span> ".
							$entry->name. 
							" <i class=\"fa fa-pencil\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/"
								.$entry->CID
								."/modal'})\"></i>");
						subCategories($entry);
						echo("</li>");
					}
				// }
			}

			function subCategories($parentCategory) {
				$id = Auth::user()->id;
				$subCats = DB::select("select * from log_category c where c.pid =  $parentCategory->CID");
				if ($subCats != NULL){
					echo("<ul>\n");
					foreach($subCats as $sub){

						if ($sub->isTask == 0){
							echo ("<li>".
								"<span style=color:#".
								$sub->color.
								">".
								"<i class=\"fa fa-square\"></i>".
								"</span> ".
								$sub->name.
								" <i class=\"fa fa-pencil\" onclick=\"return $('#thisModal').modal({remote: '/log/editCat/".
								$sub->CID.
								"/modal'})\"></i>");
							subCategories($sub);
							echo("</li>");
						}

						else{
							echo ("<li>" .
							"<span style=color:#".
							$sub->color.
							">".
							"<i class=\"fa fa-square\"></i>".
							"</span> ".
							$sub->name. 
							" <i class=\"fa fa-pencil\" onclick=\"return $('#thisModal').modal({remote: '/log/editTask/".
							$sub->CID
							."/modal'})\"></i>");

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