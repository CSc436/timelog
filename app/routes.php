<?php

// Include the REST API routes

require_once('api_routes.php');

// Destination route for things you can click on the menu or other home page links

Route::any('/', function()
{
	return View::make('index')->with('active', 'home');
});

Route::get('about', function()
{
	return View::make('about')->with('active', 'about');
});

Route::get('contact', function()
{
	return View::make('contact')->with('active', 'contact');
});

Route::get('login', array('as' => 'login', function()
{
	if (Auth::check())
	{
		return Redirect::to('/');
	} else {
		return View::make('login')->with(array('active'=> 'login', 'failed'=> false));
	}
	
}));

Route::get('logout', function(){

	Auth::logout();
	return Redirect::to('/login')->with('success', 'You are now logged out.');

});


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

	Route::get('profile', function()
	{
		return View::make('profile')->with('active', 'profile');
	});

	// ---- Dashboard -----

	Route::get('dashboard', function()
	{
		return View::make('dashboard')->with('active', 'dashboard');
	});

	// ---- LogController -----

	Route::get('log/view', function()
	{
		$query = DB::table('log_entry')->orderBy('endDateTime', 'asc')->get();

		return View::make('view')->with('query', $query)->with('active', 'viewlog');
	});

	Route::get('log/add', 'LogController@getLogAdd');

	Route::get('log/addlog_cal', function()
	{
		return View::make('addlog_cal')->with('active', 'addlog_cal');
	});

	Route::post('log/add_cal', 'LogController@addEntry');

	// handles both add and edit log entry actions
	Route::post('log/save/{id?}', 'LogController@saveEntry')->where('id', '[0-9]+');
	Route::get('log/edit/{id}', 'LogController@editEntry')->where('id', '[0-9]+');


	// ---- User password change (if logged in)
	Route::post('password/change', 'UserController@changePassword');

Route::get('api/log/pie', function()
{
	// select name, color, duration from log_entry e, log_category c where c.cid = e.cid and c.uid = e.uid
	$data = DB::select("select name as label, CAST(SUM(duration) as unsigned) as value , color as color from log_category c, log_entry e where c.cid = e.cid group by label");
	return $data;
});


