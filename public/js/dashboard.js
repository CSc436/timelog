$(function() {

	window.Dashboard = window.Dashboard || {};

	Dashboard.getWeather = function() {
		$.ajax({
			url: "http://api.wunderground.com/api/d513969ef432e427/geolookup/conditions/q/IA/Tucson.json",
			dataType: "jsonp",
			success: function(parsed_json) {
				var location = parsed_json['location']['city'];
				var temp_f = parsed_json['current_observation']['temp_f'];
				
				$("#temperature").html(temp_f + " &deg;F");
				
				var icon_url = parsed_json['current_observation'].icon_url;
				var icon = $("<img>", { src: icon_url});
				$("#weather-condition").append(icon);
				$("#location").text(location);

				console.log(parsed_json);

			}
		});
	}

	Dashboard.getTime = function(){
		$("#time").text(moment().format("hh:mma"));
		$("#date").text(moment().format("ddd / MMMM DD / YYYY"));
	}

	Dashboard.getDeadline = function(){
		
	}

	Dashboard.getWeather();
	Dashboard.getTime();
	Dashboard.getDeadline();

	window.setInterval(function(){
		Dashboard.getWeather();
	}, 900000);
	
	window.setInterval(function(){
		Dashboard.getTime();
	}, 60000);

});