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
		$validator = Validator::make(Input::all(), array(
			'entryname' => 'required|alpha_dash|min:1',
			'startDateTime' => 'required|date',
			'endDateTime' => 'date',
			'category' => 'alpha_dash'
			)
		);
		if ($validator->passes()) {
			// validation has passed, save user in DB
			$results = DB::select('select * from log_entry');
			
			return View::make('success');
		} else {
			// validation has failed, display error messages
			$data['msgs'] = $validator->messages();
			return View::make('fail', $data);
		}
	}

}