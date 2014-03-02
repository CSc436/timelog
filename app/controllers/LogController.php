<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

	/*
	* getValidator: generate the validator that will be used by addEntry() and editEntry()
	*/
	private function validateInput()
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
		
		/*
		* A valid name consists of print characters and spaces, not including slashes (\ nor /).
		* A valid name is also one that is at least of length 1 when not counting white space.
		*/
		Validator::extend('validName', function($attribute, $value, $parameters)
		{
			return Utils::validateName($value);
		});
	
		// validate
		$validator = Validator::make(Input::all(), array(
			'entryname' => 'required|validName',
			'startDateTime' => 'required|date',
			'endDateTime' => 'required|date|after_start:startDateTime',
			'category' => 'alpha_dash'
			),
			array('after_start' => 'End date-time must be after start date-time.')
		);

		return $validator;
	}

	public function saveEntry($id = null)
	{	
		// user must be logged in!
		if(!Auth::check()){
			return Response::make('Not Found', 404);
		}

		if($id == null){
			// create new LogEntry
			$entry = new LogEntry;
		}else{
			// load existing LogEntry
			try{
				$entry = LogEntry::where('UID', '=', Auth::user()->id)->findOrFail($id);
			}catch(ModelNotFoundException $e){
				return Response::make('Not Found', 404);
			}
		}
		
		$validator = $this->validateInput(); // validate input from Input::all()
		
		if ($validator->passes()) {
			// validation has passed, save user in DB

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
			$entry->notes = Input::get('notes');
			$entry->UID = Auth::user()->id;
			$entry->save();

			return Redirect::to('log/view');
		} else if($id == null) {
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/add')->withErrors($validator);
		}else{
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/edit/'.$id)->withErrors($validator);
		}
	}

	public function editEntry($id)
	{	
		// user must be logged in!
		if(!Auth::check()){
			return Response::make('Not Found', 404);
		}

		try{
			$entry = LogEntry::where('UID', '=', Auth::user()->id)->findOrFail($id);
		}catch(ModelNotFoundException $e){
			return Response::make('Not Found', 404);
		}

		return View::make('entryform')->with('editThis', $entry);
	}

	public function getLogAdd(){
		return Auth::check() != null ? View::make('entryform')->with('active', 'addlog') : Redirect::to('login');
	}
}