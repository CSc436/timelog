$(function() {

	window.Dashboard = window.Dashboard || {};

	Dashboard.getWeather = function() {
		$.ajax({
			url: "http://api.wunderground.com/api/d513969ef432e427/geolookup/conditions/q/IA/Tucson.json",
			dataType: "jsonp",
			success: function(parsed_json) {
				var location = parsed_json['location']['city'];
				var temp_f = parsed_json['current_observation']['temp_f'];
				
				$("#temparature").text(temp_f);
				$("#weather-condition").text(temp_f);
				$("#location").text(location);
			}
		});
	}

	Dashboard.getTime = function(){
		$("#time").text(moment().format("hh:mma"));
	}

	Dashboard.getWeather();
	Dashboard.getTime();

	window.setInterval(function(){
		Dashboard.getWeather();
	}, 900000);
	
	window.setInterval(function(){
		Dashboard.getTime();
	}, 60000);

});