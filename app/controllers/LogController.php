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
		// getPage argument is yet to be used.
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
			$LID = $entry->LID;
			return $LID;
		}

		return null;
	}

	public function saveEntryFromAddPage($id = null){
		if($this->saveEntry($id)){
			return Redirect::to('log/view');
		}else if($id == null) {
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/add')->withErrors($validator);
		}else{
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/edit/'.$id)->withErrors($validator);
		}
	}

	//This function bypasses returning a page upon successful submission to optimize for speed.
	public function saveEntryFromCalendar($id = null){
		if($LID = $this->saveEntry($id)){
			return $LID;
		}else if($id == null) {
			//TODO: validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/add')->withErrors($validator);
		}else{
			//TODO: validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/edit/'.$id)->withErrors($validator);
		}
	}

	public function editEntry($id, $modal = false)
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

		if($modal === false)
			return View::make('entryform')->with('editThis', $entry);
		else
			return View::make('entryform_modal')->with('editThis', $entry);
	}

	public function getLogAdd($modal = false){
		return Auth::check() != null ? ($modal == false ? View::make('entryform')->with('active', 'addlog') : View::make('entryform_modal')->with('active', 'addlog')) : Redirect::to('login');
	}


	/*
	* validateCategory: generate the validator that will be used by addCategory() and editEntry()
	*/
	private function validateCategory()
	{
		
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
			'categoryName' => 'required|validName',
			'taskDeadline' => 'date'
			)
		);

		return $validator;
	}


	public function saveCategory($id = null) {
		
		if(!Auth::check()){
			return Response::make('Must be logged int to save a category', 404);
		}
		if($id == null){
			// create new category entry
			$catEntry = new logCategory;
		}		
		$validator = $this->validateCategory(); // validate input from Input::all()
		
		if ($validator->passes()) {

			// validation has passed, save category in DB
			$catEntry->UID = Auth::user()->id;
			$catEntry->name = Input::get('categoryName');

			
			$superCategory = Input::get('superCategory');

			$catEntry->PID = DB::table('log_category')->where('name',$superCategory)->where('UID',Auth::user()->id)->pluck('CID');

			$catEntry->isTask = Input::get('isTask');
			
			$catEntry->deadline = Input::get('taskDeadline');

			$star = Input::get('starRating');

			if(!$catEntry->isTask == 'on'){
				$catEntry->isTask = 0;
				$catEntry->isCompleted = 0;
				$catEntry->rating = 0;
			}
			else {
				$catEntry->rating= $star;
				if ($star == 0) {
					$catEntry->isCompleted = 0;
				}
				else {
					$catEntry->isCompleted = 1;
				}
			}

			//save category to database
			$catEntry->save();

			return Redirect::to('log/view');
		} else if($id == null) {
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/addCategory')->withErrors($validator);
		}else{
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/edit/'.$id)->withErrors($validator);
		}

	}
}