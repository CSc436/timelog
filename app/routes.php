<?php

// Destination route for things you can click on the menu

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
	return Redirect::to('/')->with('success', 'Thanks for registering!');
});

Route::get('profile', function()
{
	if (Auth::check())
	{
		return View::make('profile')->with('active', 'profile');
	} else {
		return Redirect::to('login');
	}
});


// ------------------- ReminderController Routes --------------------


Route::post('password/reset', "RemindersController@postRemind");

Route::get('password/reset/{token}', 'RemindersController@getReset');

Route::post('password/reset/now', 'RemindersController@postReset');


// ------------------- UserController Routes --------------------


Route::get('users', 'UserController@getAllUsers');

// Route to login strategy
Route::post('login', 'UserController@postUserLogin');

// Route to signup strategy
Route::post('signup', 'UserController@postNewUser');

Route::post('password/change', 'UserController@changePassword');

// ------------------- LogController Routes --------------------

Route::get('log/add', 'LogController@getLogAdd');

Route::get('log/addlog_cal', function()
{
	return Auth::check() != null ? View::make('addlog_cal')->with('active', 'addlog_cal') : Redirect::to('login');
});

Route::post('log/add_cal', 'LogController@addEntry');

// handles both add and edit log entry actions
Route::post('log/save/{id?}', 'LogController@saveEntry')->where('id', '[0-9]+');
Route::get('log/edit/{id}', 'LogController@editEntry')->where('id', '[0-9]+');

Route::get('log/view', function()
{
	$query = DB::table('log_entry')->orderBy('endDateTime', 'asc')->get();

	return View::make('view')->with('query', $query)->with('active', 'viewlog');
});


Route::get('api/log/view', function()
{
	$data = DB::select("select DATE_FORMAT(startDateTime,'%m-%d-%y') as label, duration as value from log_entry order by label asc, duration desc");
	return $data;
});


// ------------------- Dashboard Routes --------------------

Route::get('dashboard', function()
{
	return View::make('dashboard')->with('active', 'profile');
});
