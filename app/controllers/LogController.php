<?php

class LogController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Log Entry Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles log entry requests such as adding new entries and
	| modifying previous entries.
	|
	*/

	public function addEntry()
	{
		
		/*
		*  Returns true if the date-time value of this field is greater than the
		*  value of the provided attribute name.
		*
		*  Format:
		*    after_start:startAttributeName
		*
		*/
		Validator::extend('after_start', function($attribute, $value, $parameters)
		{
			$start = new DateTime(Input::get($parameters[0]));
			$end = new DateTime($value);

			return $end > $start;
		});
	
		// validate
		$validator = Validator::make(Input::all(), array(
			'entryname' => 'required|alpha_dash|min:1',
			'startDateTime' => 'required|date',
			'endDateTime' => 'required|date|after_start:startDateTime',
			'category' => 'alpha_dash'
			),
			array('after_start' => 'End date-time must be after than start date-time.')
		);
		
		if ($validator->passes()) {
			// validation has passed, save user in DB
			
			// LogEntry
			$entry = new LogEntry;
			$entry->startDateTime = Input::get('startDateTime');
			$entry->endDateTime = Input::get('endDateTime');
			
			// calculate duration
			
			$start = new DateTime($entry->startDateTime);
			$end = new DateTime($entry->endDateTime);
			
			$interval = $start->diff($end);
			$d = intval($interval->format('%a'));
			$h = intval($interval->format('%h'));
			$m = intval($interval->format('%i'));
			$entry->duration = ((($d * 24) + $h) * 60) + $m;
			
			// save to DB
			$entry->notes = '';
			$entry->save();
			
			return View::make('success');
		} else {
			// validation has failed, display error messages
			$data['msgs'] = $validator->messages();
			return View::make('fail', $data);
		}
	}

}