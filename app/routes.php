<?php

// Include the REST API routes

require_once('api_routes.php');

// Destination route for things you can click on the menu or other home page links

Route::any('/', 'PagesController@Index');
Route::get('about', 'PagesController@About');
Route::get('contact', 'PagesController@Contact');
Route::get('login', 'PagesController@Login');
Route::get('logout', array('as' => 'logout', 'uses' => 'PagesController@LogOut'));
Route::get('privacy', 'PagesController@PrivacyPolicy');
Route::get('terms', 'PagesController@TermsOfService');


// ------------------- ReminderController Routes ----------------
Route::post('password/reset', "RemindersController@postRemind");
Route::get('password/reset/{token}', 'RemindersController@getReset');
Route::post('password/reset/now', 'RemindersController@postReset');


// ------------------- UserController Routes --------------------
Route::get('users', 'UserController@getAllUsers');

// Route to login strategy
Route::post('login', 'UserController@postUserLogin');

// Route to signup strategy
Route::post('signup', 'UserController@postNewUser');


// ------------------- Authenticated Routes --------------------

Route::group(array('before' => 'auth'), function(){

	// ---- User personal pages -----

	Route::get('profile', array('as' => 'profile', function()
	{
		return View::make('profile')->with('active', 'profile');
	}));

	// ---- Dashboard -----
	Route::get('dashboard', function()
	{
		return View::make('dashboard')->with('active', 'dashboard');
	});

	//Retrieves entries for calendar interface desplay
	Route::get('log/view_cal', function()
	{	
		$user = Auth::user();
		$uid = $user->id;
		$query = DB::table('log_entry')->where('UID', '=', $uid)->orderBy('endDateTime', 'asc')->get();

		return Auth::check() != null ? $query : Redirect::to('login');
	});

	//Retrieves catagories for calendar interface desplay
	Route::get('log/view_cat_cal', function()
	{	
		$user = Auth::user();
		$uid = $user->id;
		$query = DB::table('log_category')->where('UID', '=', $uid)->get();

		return Auth::check() != null ? $query : Redirect::to('login');
	});

	//Get logs for view logs page
	Route::get('log/view', 'VisController@visualize');
	/*Route::get('log/view', function()
	{
		$date = explode("/", Input::get('dates'));
		$id = Auth::user()->id;
		$categories = DB::select("select name, cid from log_category c where c.uid = $id");
		$timeFrame = DB::select("select YEAR(startDateTime) as year, MONTH(startDateTime) as month from log_entry GROUP BY YEAR(startDateTime), MONTH(startDateTime) ORDER BY YEAR(startDateTime), MONTH(startDateTime)");
		// $timeFrame = DB::table("log_entry")
		// 	->select(DB::RAW("YEAR(startDateTime) AS year"))
		// 	->select(DB::RAW("MONTH(startDateTime) AS month"))
		// 	->groupBy(DB::RAW("YEAR(startDateTime)"))
		// 	->groupBy(DB::RAW("MONTH(startDateTime)"))
		// 	->orderBy(DB::RAW("YEAR(startDateTime)", "asc"))
		// 	->orderBy(DB::RAW("MONTH(startDateTime)", "asc"))->get();
		$selectedMonth = array();
		$selectedMonth["0/0"] = "-----";
		foreach ($timeFrame as $time) {
			$selectedMonth[$time->month."/".$time->year] = $time->month."/".$time->year;
		}

		if($date[0] == 0) { // Determines the month and year that want to be inspected
			$query = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select('LID','log_entry.CID','color', 'name', 'startDateTime', 'endDateTime', 'duration', 'notes')
				->where('log_entry.uid', '=', "$id")
				->orderBy('startDateTime','ASC')
				->get();
			$query_chart = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select(DB::RAW("`log_entry`.`CID`, `name`, `color`, SUM(`duration`) AS 'duration', MIN(`startDateTime`) AS 'startDateTime'")) //, COUNT(`LID`) AS 'count'"))
				->where('log_entry.uid', '=', "$id")
				->groupBy('log_entry.CID')
				->groupBy(DB::RAW("YEAR(startDateTime)"))
				->groupBy(DB::RAW("MONTH(startDateTime)"))
				->groupBy(DB::RAW("DAY(startDateTime)"))
				->orderBy('startDateTime','ASC')
				->get();
		} else {
			$query = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select('LID','log_entry.CID','color', 'name', 'startDateTime', 'endDateTime', 'duration', 'notes')
				->where(DB::RAW('MONTH(startDateTime)'), '=', $date[0])
				->where(DB::RAW('YEAR(startDateTime)'), '=', $date[1])
				->where('log_entry.uid', '=', "$id")
				->orderBy('startDateTime','DESC')
				->get();
			$query_chart = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select('LID','log_entry.CID','color', 'name', 'startDateTime', 'endDateTime', 'duration', 'notes')
				->where(DB::RAW('MONTH(startDateTime)'), '=', $date[0])
				->where(DB::RAW('YEAR(startDateTime)'), '=', $date[1])
				->where('log_entry.uid', '=', "$id")
				->orderBy('startDateTime','DESC')
				->get();
		}

		

		return View::make('view')->with(array('query' => $query, 'query_chart' => $query_chart, 'categories' => $categories, 'dates' => $selectedMonth, 'active' =>'viewlog'));
	});*/

		//Get logs for viewCategories logs page 
	Route::get('log/viewCategory', function()
	{
		$id = Auth::user()->id;
		$categories = DB::select("select * from log_category c where c.uid = $id");
		//$categories = Route::get('api/api_routes');
		return View::make('viewCategories')->with('categories', $categories)->with('active', 'viewCat');
	});

	//This should be named better, the naming scheme for the function is confusing
	Route::get('log/add', 'LogController@getLogAdd');
	Route::get('log/add/modal', function(){return (new LogController)->getLogAdd(true);});

	//Direct to calendar page
	Route::get('log/addlog_cal', function()
	{
		return View::make('addlog_cal')->with('active', 'addlog_cal');
	});

	// Return a single log
	
	/* Route::get('log/{id}', function($id)
	{
		$user_id = Auth::user()->id;
		$log = LogEntry::where(array('uid' => $user_id, 'lid' => $id));
		return $log;

	})->where('id', '[0-9]+'); */

	//Route::post('log/add_call', 'LogController@saveEntryFromAddPage');
	
	//Add an event from the calendar interface
	Route::post('log/add_from_calendar', 'LogController@saveEntryFromCalendar');
	Route::post('log/save_from_calendar/{id?}', 'LogController@saveEntryFromCalendar')->where('id', '[0-9]+');

	// handles both add and edit log entry actions
	//Route::post('log/save/{id?}/{getPage?}', 'LogController@saveEntry')->where('id', '[0-9]+')->where('getPage', 'false');
	
	Route::post('log/save/{id?}', 'LogController@saveEntryFromAddPage')->where('id', '[0-9]+');
	
	Route::get('log/edit/{id}', 'LogController@editEntry')->where('id', '[0-9]+');
	Route::get('log/edit/{id}/modal', function($id){return (new LogController)->editEntry($id, true);})->where('id', '[0-9]+');

	// ---- User password change (if logged in)
	Route::post('password/change', 'UserController@postChangeUserPassword');

	// ---- User email change (if logged in)
	Route::post('email/change', 'UserController@postChangeUserEmail');

	Route::get('achievements', function()
	{
		return View::make('achievements')->with('active', 'achievements');
	});


	Route::post('log/saveCat{id?}','logController@saveCategory')->where('id', '[0-9]+');

	Route::get('log/editCat/{catID}/modal', function($catID){return (new LogController)->editCat($catID, true);})->where('catID', '[0-9]+');
	Route::get('log/editTask/{catID}/modal', function($catID){return (new LogController)->editTask($catID, true);})->where('catID', '[0-9]+');
	Route::post('log/updateCat/{catID?}', 'logController@updateCategory')->where('catID', '[0-9]+');
	//Route::get('log/edit/{id}', 'LogController@editCat')->where('id', '[0-9]+');

	Route::get('log/addCategory', function(){
		return View::make('addCategory')->with('active', 'category');
	});

	Route::get('log/tasks', function(){
		return View::make('viewTasks');
	});

	Route::get('log/tasks/completed', function(){
		return View::make('viewTasks')->with('completed', 'true');
	});
	
	//Delete User
	Route::post('profile/delete', 'UserController@deleteUser');
});

