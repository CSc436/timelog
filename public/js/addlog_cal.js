$(function() {

	$.ajaxSetup({
		aync: false
	});

	window.SundialCalendar = {};

	var categories = [];

	$.get("/log/view_cat_cal", function(cats) {
		for (var i = 0; i < cats.length; i++) {
			categories.push({
				title: cats[i].name,
				id: cats[i].CID,
				color: cats[i].color
			});
		}
	});

	var eventsBeforeParsed = [];
	eventsAfterParsed = [];

	$.get("/log/view_cal", function(events) {

		eventsBeforeParsed = events;

		for (var i = 0; i < events.length; i++) {

			events[i].color = "#000000";

			for (var j = 0; j < categories.length; j++) {
				if (events[i].CID == categories[j].id) {
					events[i].color = "#" + categories[j].color;
					events[i].category = categories[j].title;
					events[i].categoryId = categories[j].id;
				}
			}

			eventsAfterParsed.push({
				title: events[i].category,
				categoryId: events[i].categoryId,
				start: new Date(events[i].startDateTime),
				end: new Date(events[i].endDateTime),
				allDay: false,
				description: events[i].notes,
				id: events[i].LID,
				backgroundColor: events[i].color
			});
		}

		SundialCalendar.calendar.fullCalendar('refetchEvents');

	});

	SundialCalendar.calendar = $('#calendar').fullCalendar({
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
			eventEditorModal(start, end, null);
		},
		eventClick: function(calEvent, jsEvent, view) {
			eventEditorModal(calEvent.start, calEvent.end, calEvent);
			console.log(calEvent);
		},
		eventDrop: function(calEvent, dayDelta, minuteDelta, allDay, revertFunc) {

			var stFromatted = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm");
			var etFromatted = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm");

			$.post("/log/save_from_calendar/" + calEvent.id, {
				entryname: calEvent.title,
				category: calEvent.categoryId,
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
				category: calEvent.categoryId,
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

	console.log('poop');

	$(document).on("submit", "#thisModal form", function(event) {
		submitEvent();
		event.preventDefault();
	});

	$('body').on('hidden.bs.modal', '.modal', function() {
		$(this).removeData('bs.modal');
		$('#thisModal').html("");
	});

});

function eventEditorModal(start, end, calEvent) {

	var start, end;

	if (calEvent) {
		start = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm");
		end = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm");

		$("#thisModal").on("shown.bs.modal", function() {
			$("#startDateTime").val(start);
			$("#endDateTime").val(end);
			$("#category").val(calEvent.categoryId);
			$("#notes").val(calEvent.description);
		});

	} else {

		start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm");
		end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm");

		$("#thisModal").on("shown.bs.modal", function() {
			$("#startDateTime").val(start);
			$("#endDateTime").val(end);
		});
	}

	$('#thisModal').modal({
		remote: '/api/log/edit/modal'
	});
}

function submitEvent(update, id) {

	var form = $("#thisModal form");

	var url = '/api/log/save';

	if (update) {

		url = '/log/save_from_calendar/' + id;

		form.append($("<input>", {
			value: id,
			type: "hidden",
			name: "id"
		}));
	}

	$.post(url, form.serialize(), function(data) {

		if (update) {
			console.log("Event updated!", data);
		} else {
			console.log("New event created!", data);
		}

		SundialCalendar.calendar.fullCalendar('renderEvent', {
				title: data.notes,
				description: data.notes,
				id: data.LID,
				category: data.CID,
				start: data.startDateTime,
				end: data.endDateTime,
				allDay: false,
			},
			true);
	});

	SundialCalendar.calendar.fullCalendar('unselect');

	if ($('#thisModal')) {
		$('#thisModal').modal('hide');
	}
}