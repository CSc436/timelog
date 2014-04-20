$(function() {

	$(document).on("submit", "#thisModal form", function() {

		$.post('/api/log/save/', $(this).serialize(), function(data) {
			console.log(data);
			$("#thisModal").modal('hide');
		});

		event.preventDefault();
	});

	$('body').on('hidden.bs.modal', '.modal', function() {
		$(this).removeData('bs.modal');
		$('#thisModal').html("");
	});

	jQuery.ajaxSetup({
		async: false
	});

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();


	var categories = [];

	$.get("/log/view_cat_cal", function(cats) {
		//TODO: do selective querying when real dates are used, so we don't have to
		//get all events, however, it is unclear yet how much of a performance bottleneck
		//this will be.
		for (var i = 0; i < cats.length; i++) {
			categories.push({
				title: cats[i].name,
				id: cats[i].CID,
				color: cats[i].color
			});
		}
	});

	var eventsBeforeParsed = [];
	var eventsAfterParsed = [];

	$.get("/log/view_cal", function(events) {

		console.log(categories);
		eventsBeforeParsed = events;
		console.log(events);
		//TODO: do selective querying when real dates are used, so we don't have to
		//get all events, however, it is unclear yet how much of a performance bottleneck
		//this will be.

		for (var i = 0; i < events.length; i++) {
			events[i].color = "#FFFFFF";
			for (var i2 = 0; i2 < categories.length; i2++) {
				if (events[i].CID == categories[i2].id) {
					events[i].color = "#" + categories[i2].color;
				}
			}

			eventsAfterParsed.push({
				title: "placeholder title",
				start: new Date(events[i].startDateTime),
				end: new Date(events[i].endDateTime),
				allDay: false,
				description: events[i].notes,
				id: events[i].LID,
				backgroundColor: events[i].color
			});
		}
	});

	var calendar = $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title'
		},
		selectable: true,
		selectHelper: true,
		allDaySlot: false,
		slotMinutes: 15,
		defaultView: "agendaWeek",
		editable: true,
		events: eventsAfterParsed,
		select: function(start, end, allDay) {

			$("#thisModal").on("shown.bs.modal", function() {
				$("#startDateTime").val($.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm"));
				$("#endDateTime").val($.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm"));
			});

			$('#thisModal').modal({
				remote: '/api/log/edit/modal'
			});

			calendar.fullCalendar('unselect');
		},
		eventClick: function(calEvent, jsEvent, view) {
			//Edit existing event

			var tmp;
			var title;
			var description;


			$('#thisModal').modal({
				remote: '/api/log/edit/modal'
			});

		},
		eventDrop: function(calEvent, dayDelta, minuteDelta, allDay, revertFunc) {

			var stFromatted = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm");
			var etFromatted = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm");

			$.post("/log/save_from_calendar/" + calEvent.id, {
				entryname: calEvent.title,
				category: "placeholder",
				startDateTime: stFromatted,
				endDateTime: etFromatted,
				notes: calEvent.description
			})
		},
		eventResize: function(calEvent, dayDelta, minuteDelta, revertFunc) {

			var stFromatted = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm");
			var etFromatted = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm");

			$.post("/log/save_from_calendar/" + calEvent.id, {
				entryname: calEvent.title,
				category: "placeholder",
				startDateTime: stFromatted,
				endDateTime: etFromatted,
				notes: calEvent.description
			});
		},
		eventRender: function(event, element) {
			if (event.description != null) {
				element.find('.fc-event-title').prepend("<b>").append("</b><br/>" + event.description);
			}
		}
	});

});

function saveEntry(){

	var formData = $("#thisModal form").serialize();

	$.post('/api/log/save/', $("#thisModal form").serialize(), function(data) {

		var entryId = +data;

		if($.isNumeric(entryId)){
			$("#thisModal").modal('hide');
			return formData;
		} else{
			return data;
		}
	});
}





