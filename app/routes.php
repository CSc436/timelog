<?php

// Include the REST API routes

require_once('api_routes.php');

// Destination route for things you can click on the menu or other home page links

Route::any('/', 'PagesController@Index');
Route::get('about', 'PagesController@About');
Route::get('contact', 'PagesController@Contact');
Route::get('login', 'PagesController@Login');
Route::get('logout', 'PagesController@LogOut');
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

	Route::get('profile', function()
	{
		return View::make('profile')->with('active', 'profile');
	});

	// ---- Dashboard -----

	Route::get('log/view', function()
	{	
		$user = Auth::user();
		$uid = $user->id;
		$query = DB::table('log_entry')->where('UID', '=', $uid)->orderBy('endDateTime', 'asc')->get();

		return Auth::check() != null ? View::make('view')->with('query', $query)->with('active', 'viewlog') : Redirect::to('login');
	});

	Route::get('log/view_cal', function()
	{	
		$user = Auth::user();
		$uid = $user->id;
		$query = DB::table('log_entry')->where('UID', '=', $uid)->orderBy('endDateTime', 'asc')->get();

		return Auth::check() != null ? $query : Redirect::to('login');
	});

	Route::get('dashboard', function()
	{
		return View::make('dashboard')->with('active', 'dashboard');
	});


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
	Route::post('password/change', 'UserController@postChangeUserPassword');
	// ---- User email change (if logged in)
	Route::post('email/change', 'UserController@postChangeUserEmail');
	
	
	// ---- Achievements ----
	Route::get('achievements', function()
	{
		return View::make('achievements')->with('active', 'achievements');
	});
	
});
