<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Time Log</title>
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">				
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><i class="fa fa-calendar"></i> Time Log</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">

					<li  <?php if ($active == "home") echo"class=active"?> ><a href="/">Home</a></li>
					<li <?php if ($active == "about") echo"class=active"?>> <a href="/about">About</a></li>
					<li <?php if ($active == "contact") echo"class=active"?>><a href="/contact">Contact</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(!Auth::check())  
	                    <li><a href="/login"><i class="fa fa-sign-in"></i> Sign In</a></li>  
	                @else
	                    <li><a href="/logout"><i class="fa fa-sign-out"></i> Sign Out</a></li>
	                @endif
                </ul>
				
			</div><!--/.navbar-collapse -->
		</div>			
	</div> <!-- /container -->

	<div class="container" id="main">
		@yield('content')
	</div>

	<hr>
	<footer>
		Time Log &copy; 2014 
	</footer>

	<script src="/js/jquery-2.1.0.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/main.js"></script>
</body>
</html>
