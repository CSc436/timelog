@extends('layout')

@section('content')

	{{ Session::get("success") }}

	<div class="jumbotron timelog-jumbotron">
	  <h1>Time Logging, Task Planning and Management</h1>
	  <p>Time Log makes it really easy to log your tasks and help you plan your tasks effortlessly. The use of Time Log guarantees you with maximum productivity and minimum stress.</p>
	</div>

	<h1 class='feature-title'>Features</h1>

	<section class="timelog-features">
		<div class="row">
		  <div class="col-md-10 col-md-offset-1">
			<div class="row">
			  
				<div class="col-md-4">
				<h2><i class="fa fa-clock-o"></i> Time Logging</h2>
				<p>As a user, you can log times and manage your tasks hassle free.</p>
				</div>

				<div class="col-md-4">
				<h2><i class="fa fa-calendar"></i> Task Planning</h2>
				<p>You can create tasks and plan them according to your availability.</p>
				</div>

				<div class="col-md-4">
				<h2><i class="fa fa-flag"></i> Goals</h2>
				<p>We make sure that you are achieving all your set goals by helping you track goal and set complete status.</p>
				</div>

				<div class="col-md-4">
				<h2><i class="fa fa-star"></i> Achievements</h2>
				<p>In order to motivate you to complete your tasks on time and be productive, we offer achievement points and medals
				upon completion of a challenging task.</p>
				</div>

				<div class="col-md-4">
				<h2><i class="fa fa-globe"></i> Web Application</h2>
				<p>Time Log runs in all modern web browsers which means you don't need to worry about installing additional software to run it.</p>
				</div>

				<div class="col-md-4">
				<h2><i class="fa fa-dollar"></i> Pricing</h2>
				<p>All the core features offered by Time Log are free. However, if you need more features, you can upgrade to Time Log Pro for just $7 per month. 10% of $7 that you spend monthly goes to a non-profit charity organiation.</p>
				</div>

			</div>
		  </div>
	  
	  </section>
	  </div>

@stop