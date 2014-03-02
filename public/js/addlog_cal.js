	$(document).ready(function() {
	
		//$('.event').tooltip();
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
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
				calendar.fullCalendar('unselect');
			},
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
				},
				{
					title: 'Lunch',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false
				},
				{
					title: 'Birthday Party',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false
				},
				{
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/'
				}
				],*/
			eventRender: function(event, element) { 
				//element.title="Tooltip on top"
				if(event.description != null){
					element.find('.fc-event-title').prepend("<b>").append("</b><br/>" + event.description);
				}
			},
			eventClick: function(calEvent, jsEvent, view) {
				var title = prompt('What were you working on:', calEvent.title, { buttons: { Ok: true, Cancel: false} });
				var description = prompt('Notes:', calEvent.description, { buttons: { Ok: true, Cancel: false} });

				if (title){
					  calEvent.title = title;
					  calEvent.description = description;
					  calendar.fullCalendar('updateEvent',calEvent);
					  calendar.fullCalendar('updateEvent',calEvent);
				}
			}
		});
	});