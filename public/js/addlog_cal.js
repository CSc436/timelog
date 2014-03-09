$(document).ready(function() {
	
	jQuery.ajaxSetup({async:false});
	//$('.event').tooltip();
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	var eventsBeforeParsed = [];
	var eventsAfterParsed = [];
	$.get( "/log/view_cal", function(events) {
		eventsBeforeParsed = events;
		console.log(events);
		//TODO: do selective querying when real dates are used, so we don't have to
		//get all events, however, it is unclear yet how much of a performance bottleneck
		//this will be.
		for ( var i=0; i<events.length; i++ ) {
 			eventsAfterParsed.push({
 				title : "placeholder title",
				start: new Date(events[i].startDateTime),
				end: new Date(events[i].endDateTime),
				allDay: false,
				description: events[i].notes,
				id : events[i].LID
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
			var title = prompt('What were you working on:');
			var description = prompt('Notes:');
			if (title) {
				calendar.fullCalendar('renderEvent',
					{
						title: title,
						description: description,
						start: start,
						end: end,
						allDay: allDay
					},
					true // make the event "stick"
				);
			}

			var stFromatted = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm");
			var etFromatted = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm");
			//Send data!
			$.post( "/log/add_from_calendar", { 
				entryname: title,
				category: "placeholder", 
				startDateTime:stFromatted, 
				endDateTime: etFromatted,
				notes: description
			})

			calendar.fullCalendar('unselect');
			console.log(description);
		},
		eventRender: function(event, element) { 
			//element.title="Tooltip on top"
			if(event.description != null){
				element.find('.fc-event-title').prepend("<b>").append("</b><br/>" + event.description);
			}
		},
		eventClick: function(calEvent, jsEvent, view) {
			var tmp;
			var title;
			var description;
			if(tmp = prompt('What were you working on:', calEvent.title, { buttons: { Ok: true, Cancel: false} })){title = tmp;}
			else{title = calEvent.title;}

			if(tmp = prompt('Category:', calEvent.description, { buttons: { Ok: true, Cancel: false} })){description = tmp;}
			else{description = calEvent.description;}

			if (title){
				  calEvent.title = title;
				  calEvent.description = description;
				  calendar.fullCalendar('updateEvent',calEvent);
			}

			var stFromatted = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd HH:mm");
			var etFromatted = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd HH:mm");

			$.post( "/log/add_from_calendar", { 
				entryname: title, 
				category: "placeholder", 
				startDateTime: stFromatted, 
				endDateTime: etFromatted, 
				notes: description
			})

			console.log(description);
		}
	});
});
