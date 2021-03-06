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

			//events[i].color = "#000000";

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

		// SundialCalendar.calendar.fullCalendar('refetchEvents');

	});

	SundialCalendar.calendar = $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title'
		},
		firstDay: 1,
		selectable: true,
		firstHour: 8,
		selectHelper: true,
		allDaySlot: false,
		slotMinutes: 15,
		defaultView: "agendaWeek",
		editable: true,
		events: eventsAfterParsed,
		eventTextColor: "#000000",
		select: function(start, end, allDay) {
			eventEditorModal(start, end, null);
		},
		eventClick: function(calEvent, jsEvent, view) {
			eventEditorModal(calEvent.start, calEvent.end, calEvent);
			console.log(calEvent);
		},
		eventMouseover: function(calEvent, domEvent) {
			var layer =	"<div id='events-layer' class='fc-transparent' style='position:absolute; width:100%; height:100%; top:-1px; text-align:right; z-index:100'> <p><font color='#222222' style='padding-right:5px;' onClick='deleteEvent("+calEvent.id+");'>X</p></div>";
			$(this).append(layer);
		},   
		eventMouseout: function(calEvent, domEvent) {
			$("#events-layer").remove();
		},
		eventDrop: function(calEvent, dayDelta, minuteDelta, allDay, revertFunc) {

			var stFromatted = $.fullCalendar.formatDate(calEvent.start, "MM/dd/yyyy hh:mm TT");
			var etFromatted = $.fullCalendar.formatDate(calEvent.end, "MM/dd/yyyy hh:mm TT");

			$.post("/log/save_from_calendar/" + calEvent.id, {
				entryname: calEvent.title,
				CID: calEvent.categoryId,
				startDateTime: stFromatted,
				endDateTime: etFromatted,
				notes: calEvent.description
			})
		},
		eventResize: function(calEvent, dayDelta, minuteDelta, revertFunc) {

			var stFromatted = $.fullCalendar.formatDate(calEvent.start, "MM/dd/yyyy hh:mm TT");
			var etFromatted = $.fullCalendar.formatDate(calEvent.end, "MM/dd/yyyy hh:mm TT");

			$.post("/log/save_from_calendar/" + calEvent.id, {
				entryname: calEvent.title,
				CID: calEvent.categoryId,
				startDateTime: stFromatted,
				endDateTime: etFromatted,
				notes: calEvent.description
			});
		},
		eventRender: function(event, element) {
			if (event.description != '') {
				var duration = moment.duration(moment(event._end).diff(moment(event._start)));
				var minutes = duration.asMinutes();
				//console.log(minutes);
				if(minutes < 23){
					element.find('.fc-event-time').hide();
					//console.log(event);
				}else{
					element.find('.fc-event-time').show();
				}
				//element.find('.fc-event-title').prepend("<b>").append("</b><br/>" + event.description);
				element.find('.fc-event-title').replaceWith(event.description);
			}
		}
	});

	//SundialCalendar.calendar.scrollTime = '08:00:00';

	$(document).on("submit", "#thisModal form", function(event) {
		submitEvent();
		event.preventDefault();
	});

	$(document).on('click', "#delete", function(event) {
	  event.preventDefault(); // To prevent following the link (optional)
	  console.log("Clicked Delete");
	  deleteEvent($("#LID").val());
	  //Call code to delete event in fullCalendar.
	});

	$('body').on('hidden.bs.modal', '.modal', function() {
		$(this).removeData('bs.modal');
		$('#thisModal').html("");
	});

});

function eventEditorModal(start, end, calEvent) {

	var start2, end2;

	if (calEvent) {
		//Edit existing event
		start2 = $.fullCalendar.formatDate(calEvent.start, "MM/dd/yyyy hh:mm TT");
		end2 = $.fullCalendar.formatDate(calEvent.end, "MM/dd/yyyy hh:mm TT");

		$("#thisModal").on("show.bs.modal", function() {
			$("#startDateTime").val(start2);
			$("#endDateTime").val(end2);
			$("#thisModalLabel").text("Edit Time Entry");
			$("#CID").val(calEvent.categoryId + '');
			$("#LID").val(calEvent.id + '');
			$("#notes").val(calEvent.description);
		});

	} else {
		//New event
		start = $.fullCalendar.formatDate(start, "MM/dd/yyyy hh:mm TT");
		end = $.fullCalendar.formatDate(end, "MM/dd/yyyy hh:mm TT");

		$("#thisModal").on("show.bs.modal", function() {
			$("#startDateTime").val(start);
			$("#endDateTime").val(end);
			$("#thisModalLabel").text("Add New Time Entry");
			$("#CID").val('');
			$("#LID").val('');
			$("#notes").val('' 	);
			$('#delete').hide();
		});
	}

	$('#thisModal').modal({
		remote: '/api/log/edit/modal'
	});
}

function deleteEvent(eventId) {
	event.stopPropagation();
	var form = $("#thisModal form");
	id = eventId;
	var url = '/log/delete_from_calendar/' + id;
	SundialCalendar.calendar.fullCalendar('removeEvents', id);


	$.post(url, form.serialize(), function(data) {
		console.log("event deleted!", data);
	});

	/*	
	SundialCalendar.calendar.fullCalendar('unselect');

	if ($('#thisModal')) {
		$('#thisModal').modal('hide');
	}*/
}

function submitEvent() {

	var form = $("#thisModal form");

	update = $("#LID").val() != '';
	id = $("#LID").val();

	console.log("update: " + update + " | id: " + id);

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
			removeOldEvent(data);
			console.log("Event updated!", data);
		} else {
			console.log("New event created!", data);
		}

		addEventToCalendar(data);
	});

	SundialCalendar.calendar.fullCalendar('unselect');

	if ($('#thisModal')) {
		$('#thisModal').modal('hide');
	}
}

function removeOldEvent(data){
	SundialCalendar.calendar.fullCalendar('removeEvents', data.LID);
}

function addEventToCalendar(data){

	SundialCalendar.calendar.fullCalendar('renderEvent', {
		title: data.category,
		description: data.notes,
		id: data.LID,
		category: data.CID,
		categoryId: data.CID,
		start: data.startDateTime,
		end: data.endDateTime,
		allDay: false,
		backgroundColor: "#" + data.color
	},
	true);
}