$(function() {

	window.Dashboard = window.Dashboard || {};

	Dashboard.getWeather = function() {
		$.ajax({
			url: "http://api.wunderground.com/api/d513969ef432e427/geolookup/conditions/q/IA/Tucson.json",
			dataType: "jsonp",
			success: function(parsed_json) {
				var location = parsed_json['location']['city'];
				var temp_f = parsed_json['current_observation']['temp_f'];
				var locationDiv = $("<div>", {text: location});
				var tempDiv = $("div", {text: temp_f});
				$("#weather").append(locationDiv).append(tempDiv);
			}
		});
	}


});