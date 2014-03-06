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
				var icon = $("<img>", {
					src: icon_url
				});
				
				$("#weather-condition").html(icon);
				$("#location").text(location);

				console.log(parsed_json);

			}
		});
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

	window.setInterval(function() {
		Dashboard.getWeather();
	}, 900000);

	window.setInterval(function() {
		Dashboard.getTime();
	}, 60000);

});