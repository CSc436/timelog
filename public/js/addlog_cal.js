$(document).ready(function() {

	//$('.event').tooltip();
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	//var eventsBeforeParsed = $.;
	var eventBeforeParsed = [];
	//var eventsAfterParsed =[];
	/*eventsBeforeParsed.each(function(key){

	})*/

	for ( var i=0; i<eventsBeforeParsed.length; i++ ) {
 		//[loopBody]
	}

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
		print: ,
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
			$.post( "/log/add", { entryname: title, 
				category: description, 
				startDateTime:stFromatted, 
				endDateTime: etFromatted 
			})

			calendar.fullCalendar('unselect');
		},
		//events: EventList,
		/*events: [
			{
				title: 'My Event',
				start: new Date(y, m, d, 12, 0),
				end: new Date(y, m, d, 14, 0),
				allDay: false,
				description: 'This is a cool event'
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2)
			},
			{
				title: 'Meeting',
				start: new Date(y, m, d, 10, 30),
				allDay: false
			}]*/
		eventRender: function(event, element) { 
			//element.title="Tooltip on top"
			if(event.description != null){
				element.find('.fc-event-title').prepend("<b>").append("</b><br/>" + event.description);
			}
		},
		eventClick: function(calEvent, jsEvent, view) {
			var title = prompt('What were you working on:', calEvent.title, { buttons: { Ok: true, Cancel: false} });
			var description = prompt('Category:', calEvent.description, { buttons: { Ok: true, Cancel: false} });

			if (title){
				  calEvent.title = title;
				  calEvent.description = description;
				  calendar.fullCalendar('updateEvent',calEvent);
				  calendar.fullCalendar('updateEvent',calEvent);
			eventClick: function(calEvent, jsEvent, view) {
				var title = prompt('What were you working on:', calEvent.title, { buttons: { Ok: true, Cancel: false} });
				var description = prompt('Category:', calEvent.description, { buttons: { Ok: true, Cancel: false} });

				if (title){
					  calEvent.title = title;
					  calEvent.description = description;
					  calendar.fullCalendar('updateEvent',calEvent);
					  calendar.fullCalendar('updateEvent',calEvent);
				}

				/*
				$.post( "/log/add", { entryname: calEvent.title, 
					category: calEvent.description, 
					startDateTime:calEvent.start, 
					endDateTime: calEvent.end })
					.done(function( data ) {
					alert( "Response Loaded: " + data );
  				});*/
				//alert(calEvent.end.year);
			}

			/*
			$.post( "/log/add", { entryname: calEvent.title, 
				category: calEvent.description, 
				startDateTime:calEvent.start, 
				endDateTime: calEvent.end })
				.done(function( data ) {
				alert( "Response Loaded: " + data );
				});*/
		}
	});
});
