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
			try{
				$start = new DateTime(Input::get($parameters[0]));
				$end = new DateTime($value);
			}catch(Exception $e){
				return false;
			}

			return $end > $start;
		});
		
		/*
		* A valid name consists of print characters and spaces, not including slashes (\ nor /).
		* A valid name is also one that is at least of length 1 when not counting white space.
		*/
		Validator::extend('valid_name', function($attribute, $value, $parameters)
		{
			return Utils::validateName($value);
		});
		
		/* 
		* A valid color is a hexadecimal string of six characters without the # sign, no more,
		* no less.
		*/
		Validator::extend('valid_color', function($attribute, $value, $parameters)
		{
			return Utils::validateColor($value);
		});

		/* 
		* A valid rating is a char between 1 and 3, no more, no less.
		*/
		Validator::extend('valid_rating', function($attribute, $value, $parameters)
		{
			return Utils::validateRating($value);
		});
		/*
		* A valid name consists of print characters and spaces, not including slashes (\ nor /).
		* A valid name is also one that is at least of length 1 when not counting white space.
		*/
		Validator::extend('valid_category', function($attribute, $value, $parameters)
		{
			if($value === '0')
				return true;
			// load existing LogCategory
			try{
				$entry = LogCategory::where('UID', '=', Auth::user()->id)->where('CID', '=', $value)->firstOrFail();
			}catch(ModelNotFoundException $e){
				return false;
			}
			return true;
		});
	
		// validate
		$validator = Validator::make(Input::all(), array(
				'category' => 'integer|valid_category',
				'newcat' => 'valid_name',
				'startDateTime' => 'required|date',
				'endDateTime' => 'required|date|after_start:startDateTime',
				'color' => 'valid_color',
				'rating' => 'valid_rating'
			),
			array(
				'after_start' => 'End date-time must be after start date-time.',
				'valid_category' => 'The category you selected was not valid. Please select a different.',
				'valid_name' => 'You\'re new category name cannot have slash characters (i.e. \'/\' and \'\\\') and must be at least 1 non-white-space character long',
				'valid_color' => 'You have used an invalid color scheme',
				'valid_rating' => 'Your rating is invalid... Whoa, How did you manage to do that?'
			)
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
				return NULL;
			}
		}
		
		$validator = $this->validateInput(); // validate input from Input::all()
		
		if ($validator->passes()) {
			// validation has passed, save data in DB
			$catstr = Input::get('category');
			$cid = NULL;
			if($catstr != '0'){
				try{
					$cat = LogCategory::where('UID', '=', Auth::user()->id)->where('CID', '=', $catstr)->firstOrFail();
					$cid = $cat->CID;
				}catch(ModelNotFoundException $e){
					return NULL;
				}
			}

			$colorstr = Input::get('color');
			//$rating = Input::get('rating');
			$newcatstr = trim(Input::get('newcat'));
			if($newcatstr != ''){
				try{
					$existingcat = LogCategory::where('UID', '=', Auth::user()->id)->where('PID', '=', $cid)->where('name', '=', $newcatstr)->firstOrFail();
					$cid = $existingcat->CID;
				}catch(ModelNotFoundException $e){
					$newcat = new LogCategory;
					$newcat->UID = Auth::user()->id;
					$newcat->PID = $cid;
					$newcat->name = $newcatstr;
					$newcat->color = $colorstr;
					//$newcat->rating = $rating;
					$newcat->save();
					$cid = $newcat->CID;
				}
			}

			$entry->CID = $cid;
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
			return array($LID,$validator);
		}

		return array(null,$validator);
	}

	public function saveEntryFromAddPage($id = null){
		$val = $this->saveEntry($id); // returns [LID, $validator], where LID is NULL on error
		if($val == NULL)
			return Response::make('Not Found', 404);
		if($val[0]){
			return Redirect::to('log/view');
		}else if($id == null) {
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/add')->withErrors($val[1]);
		}else{
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/edit/'.$id)->withErrors($val[1]);
		}
	}

	//This function bypasses returning a page upon successful submission to optimize for speed.
	public function saveEntryFromCalendar($id = null){
		$val = $this->saveEntry($id); // returns [LID, $validator], where LID is NULL on error
		if($val == NULL)
			return Response::make('Not Found', 404);
		if($val[0]){
			return $val[0];
		}else if($id == null) {
			//TODO: validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/add')->withErrors($val[1]);
		}else{
			//TODO: validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/edit/'.$id)->withErrors($val[1]);
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
			file_put_contents('php://stderr', print_r($catEntry->name, TRUE));
			
			//Setup PID
			$superCategory = Input::get('superCategory');
			file_put_contents('php://stderr', print_r($superCategory, TRUE));
			$catEntry->PID = DB::table('log_category')->where('name',$superCategory)->where('UID',Auth::user()->id)->pluck('CID');
			
			$catEntry->color = Input::get('color');
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