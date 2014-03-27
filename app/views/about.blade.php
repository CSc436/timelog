@extends('layout')

@section('content')

	<div class="container" id="main">

		<h2 class="title">About Us</h2>
		<p>We are a group who has come together for a capstone computer science project at the University of Arizona. This project is to allow the user to plan and record the time it takes to to execute their plans without too much hassle. It also provides the user the ability to look at broken down analytic information of how they have spent their time.
		</p>


		<!-- Feel free to add your headshots to public/image/heads/netid.jpg -->
		<!-- The headshot should be a square. Rectangles are bad, m'kay? -->
		<!-- Let's keep the description short as well, okay? -->

		<?php $arr = array(
			"Haily De La Cruz" => array("email" => "haily@email.arizona.edu", 
				"desc" => "Web Developer, Head Time Logger, and Comic Relief", "image_url" => "/image/heads/haily.jpeg"),
			"Gopal Adhikari" => array("email" => "gopala@email.arizona.edu", 
				"desc" => "I like developing functional web applications and I am a tea enthusiast.", "image_url" => "/image/heads/gopala.jpg"),
			"Zuoming Shi" => array("email" => "zuomingshi@email.arizona.edu", 
				"desc" => "Zuoming is awesome", "image_url" => "/image/heads/zuomings.jpg"),
			"Victor Nguyen" => array("email" => "victornguyen@email.arizona.edu", 
				"desc" => "Victor is awesome", "image_url" => "http://placehold.it/150x150"),
			"Michael Knatz" => array("email" => "michaelcknatz@email.arizona.edu", 
				"desc" => "Michael is awesome", "image_url" => "http://placehold.it/150x150"),
			"James Yoshida" => array("email" => "yoshida@email.arizona.edu", 
				"desc" => "James is awesome", "image_url" => "http://placehold.it/150x150")); 
			?>
			
		<div id="dev-profiles" class="container">

			<h2>Developers</h2>

			@foreach($arr as $key => $value)
			<div class="dev col-md-3">
				<img class="dev-head" src="{{ $value['image_url'] }}">
				<h3>{{ $key }}</h3>
				<div class="dev-description">			
					<p>{{ $value["desc"] }}</p>
					<?php $email = $value["email"]; ?>
					<a href="mailto:{{ $email }}">{{ $email }}</a>
				</div>
			</div>
			@endforeach
		</div>


		<style scoped type="text/css" media="screen">
			.dev-head{
				border-radius: 50%;
				box-shadow: 0 0 12px #727279;
				width: 150px;
			}
			.dev{
				display: inline-block;
				text-align: center;
				margin: 25px;
				box-shadow: 0 0 2px #999;
				padding: 20px;
				box-sizing: border-box;
				min-height: 350px;
				max-height: 350px;
				overflow: auto;
			}
		</style>

	</div>
	
@stop