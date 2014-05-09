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
			$testName = DB::select("select * from log_category c where c.name ='" . "$catEntry->name' AND c.uid = '" . "$catEntry->UID'");
			if ($testName != NULL){
				Input::flash();
				return Redirect::to('log/addCategory')->with('message','Category name already taken')->withErrors($validator);
			}
			
			//Setup PID
			$superCategory = Input::get('superCategory');
			$catEntry->PID = DB::table('log_category')->where('CID',$superCategory)->where('UID',Auth::user()->id)->pluck('CID');
			//die(print_r($_POST));

			$catEntry->color = Input::get('color');
			$catEntry->isTask = Input::get('isTask');

			$catEntry->isCompleted = Input::get('isCompleted');
			$duedate = Input::get('hasDuedate');

			if($catEntry->isTask == '0'){
				$catEntry->isTask = 0;
				$catEntry->isCompleted = 0;
				$catEntry->rating = 0;
			}else {
				if ($catEntry->isCompleted == 0) {
					$catEntry->rating = 0;
				}else {
					$catEntry->rating = Input::get('starRating');
				}
				
				if ($duedate == 0) {
					$catEntry->deadline = NULL;
				}else {
					$catEntry->deadline = Input::get('dueDateTime');
				}
			}

			//save category to database
			$catEntry->save();

			return Redirect::to('log/view');
		} else if($id == null) {
			// validation has failed, display error messages
			Input::flash();
			if(Input::get('isTask') == '0'){
				return Redirect::to('log/addCategory')->withErrors($validator);
			}else{
				return Redirect::to('log/addTask')->withErrors($validator);
			}
		}else{
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/edit/'.$id)->withErrors($validator);
		}

	}

	public function editCat($catID, $modal = false){
		// user must be logged in!
		if(!Auth::check()){
			return Response::make('Not Found', 404);
		}

		try{
			$entry = LogCategory::where('UID', '=', Auth::user()->id)->where('CID', '=', $catID)->findOrFail($catID);

		}catch(ModelNotFoundException $e){
			return Response::make('Not Found', 404);
		}

		if($modal === false){
			//return "HERE1";
			return View::make('addCategory')->with('editThis', $entry);
		}
		else{
			return View::make('editCategory_modal')->with('editThis', $entry);
		}

	}

	public function editTask($catID, $modal = false){
		// user must be logged in!
		if(!Auth::check()){
			return Response::make('Not Found', 404);
		}

		try{
			$entry = LogCategory::where('UID', '=', Auth::user()->id)->where('CID', '=', $catID)->findOrFail($catID);

		}catch(ModelNotFoundException $e){
			return Response::make('Not Found', 404);
		}

		if($modal === false){
			//return "HERE1";
			return View::make('addTask')->with('editThis', $entry);
		}
		else{
			return View::make('editTask_modal')->with('editThis', $entry);
		}

	}	

		/* The checkCatCycle Function should be called whenever any category changes it's
	   parent category (e.g., changing a categorie's possible subcategory). This will recursively
	   check to make sure that a category is not it's own subcategory. $inputCatID is the current category of
	   the current category ID you're working with, and subCatId is the category ID of the new parent category the user
	   wants the category to be a part of. This returns 1 if there's a cycle and 0 if there is not */
	public function checkCatCycle($inputCatID, $newParentCatID) {


		if($inputCatID == $newParentCatID){
			return 1;
		}

		$subCategoryPID = DB::table('log_category')->where('CID',$newParentCatID)->where('UID',Auth::user()->id)->pluck('PID');
		
		if ($subCategoryPID == NULL){
			return "WAIT HERE";
			return 0;
		}

		if($subCategoryPID == $inputCatID){
			return 1;
		}

		else {
			return "CALLED HERE";
			return $this->checkCatCycle($inputCatID, $subCategoryPID);
		}
	}

	public function updateCategory($catID) {

		if (!Auth::check()){
			return Response::make('Not Found', 404);
		}

		if ($catID == null){
			$entry = new LogCategory;
		}
		else{
			try{
				$entry = LogCategory::where('CID', '=', $catID)->findOrFail($catID);
			}catch(ModelNotFoundException $e){
				return "Response::make('Not Found', 404)";
			}			
		}

		$validator = $this->validateCategory();

		if($validator->passes()){

			$entry->UID= Auth::user()->id;
			$entry->name = Input::get('categoryName');

			$superCategory = Input::get('superCategory');

			if ($superCategory == null){
				$entry->PID = null;
			}

			else{

				$entry->PID = Input::get('superCategory');
				if ($entry->PID == null)
					return "Response::make('parent category name doesn't exist', 404)";
				$returnValue = $this->checkCatCycle($entry->CID, $entry->PID);
				if ($returnValue == 1){
					return "Response::make('Subcategory Cycle', 404)";
				}

			}

			if($entry->PID == 0){
				$entry->PID = null;
			}

			if(Input::get('color') != null){
				$entry->color = Input::get('color');
			}

			$entry->isTask = Input::get('isTask');
			$star = Input::get('starRating');

			if(!$entry->isTask == 1){
				$entry->isTask = 0;
				$entry->isCompleted = 0;
				$entry->rating = 0;
			}
			else {
				$entry->rating= $star;
				$entry->deadline = Input::get('dueDateTime');
				if ($star == 0) {
					$entry->isCompleted = 0;
				}
				else {
					$entry->isCompleted = 1;
				}
			}

			//$updateThis = DB::table('log_category')->where('CID', '=', $catID);
			$updateThis = LogCategory::find($entry->CID);
			
			$updateThis->CID = $entry->CID;
			$updateThis->PID = $entry->PID;
			$updateThis->name = $entry->name;
			$updateThis->color = $entry->color;
			$updateThis->isTask = $entry->isTask;
			$updateThis->deadline = $entry->deadline;
			$updateThis->isCompleted = $entry->isCompleted;
			$updateThis->rating = $entry->rating;
			$updateThis->save();

			return Redirect::to('log/viewCategory');
		} 
		if($catID == null) {
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/viewCategory')->withErrors($validator);
		}else{
			// validation has failed, display error messages
			Input::flash();
			return Redirect::to('log/editCat/'.$catID.'/modal')->withErrors($validator);
		}

		}
}
