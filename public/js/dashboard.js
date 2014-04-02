$(function() {

	window.Dashboard = window.Dashboard || {};

	function geoFail(){
		console.log("Could not get location information");
		generateError("error-container", "Could not get location information using the browser. Please input your location manually.");
	}

	function generateError(errorElemId, message){
		var errBlock = $("<div>", {class: "alert alert-warning", text: message});
		$("#"+errorElemId).append(errBlock);
	}

	Dashboard.getWeather = function(position) {

		var lat, lon, url;

		console.log(position);

		if(position){
			lat = position.coords.latitude;
			lon = position.coords.longitude;
			url = "http://api.wunderground.com/api/d513969ef432e427/geolookup/conditions/q/" + lat + "," + lon + ".json";
		} else{

			// Add this feature in next iteration
			// Get user's ZIP code from the database and get make the weather api query string
			// do AJAX request and store the ZIP code in a variable
			var zipCode = "85716";
			url = "http://api.wunderground.com/api/d513969ef432e427/geolookup/conditions/q/"+ zipCode +".json";	
		}


		$.ajax({
			url: url,
			dataType: "jsonp",
			success: function(parsed_json) {

				console.log(parsed_json.location);

				var location = parsed_json.location.city;
				
				var temp_f = parsed_json['current_observation']['temp_f'];

				$("#temperature").html(temp_f + " &deg;F");

				var icon_url = parsed_json['current_observation'].icon_url;
				var icon = $("<img>", {
					src: icon_url
				});
				
				$("#weather-condition").html(icon);
				$("#location").text(location);

				console.log(parsed_json);

			}
		});
	}

	Dashboard.getLocation = function(){
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(Dashboard.getWeather, geoFail);
		}
	}

	Dashboard.getTime = function() {
		$("#time").text(moment().format("hh:mma"));
		$("#date").text(moment().format("ddd / MMMM DD / YYYY"));
	}

	Dashboard.getCategories = function() {

		$.get("/api/log/pie", function(pieData) {
			setupPieGraph(pieData);
		});

		function setupPieGraph(pieData) {
			nv.addGraph(function() {
				var chart = nv.models.pieChart()
				.x(function(d) {
					return d.label
				})
				.y(function(d) {
					return (+d.value)
				})
				.showLabels(false)
				.height(250);

				d3.select('#categories svg')
				.datum(pieData)
				.transition().duration(350)
				.call(chart);

				//d3.select(".nv-legendWrap")
				//.attr("transform", "translate(-100,100)");

				return chart;
			});
		}
	}

	Dashboard.getWeather();
	Dashboard.getTime();
	Dashboard.getCategories();
	Dashboard.getLocation();

	window.setInterval(function() {
		Dashboard.getWeather();
	}, 900000);

	window.setInterval(function() {
		Dashboard.getTime();
	}, 60000);

});