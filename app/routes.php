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
		return View::make('login')->with('active', 'login');
	}
	
}));

Route::get('logout', function(){

	Auth::logout();
	return Redirect::route('login');
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

Route::post('password/change', 'UserController@changePassword');

Route::post('password/reset', "RemindersController@postRemind");

Route::get('password/reset/{token}', 'RemindersController@getReset');

Route::post('password/reset/now', 'RemindersController@postReset');

Route::get('users', function()
{
	$users = User::all();
	return View::make('users')->with('users', $users);
});


// Login strategy
Route::post('login', function()
{
	$credentials = array(
		'username' => Input::get('username'),
		'password' => Input::get('password')
		);

	if (Auth::attempt($credentials))
	{
		return Redirect::intended('profile');
	}
	else {
		return Redirect::to('login');
	}
	
});


// Signup strategy
Route::post('signup', function()
{
	$rules = array(
		'firstname' => 'required|min:2|max:64|alpha',
		'lastname'  => 'required|min:2|max:64|alpha',
		'username'  => 'required|alpha_num|between:4,32|unique:user',
		'email'     => 'required|between:3,64|email|unique:user',
		'password'  => 'required|alpha_num|between:4,32|confirmed',
		'password_confirmation' => 'required|alpha_num|between:4,32'
		);

	$validator = Validator::make(Input::all(), $rules);

	if ($validator->passes()) {

		User::create(array(
			'firstname'     => Input::get('firstname'),
			'lastname'     => Input::get('lastname'),
			'username'     => Input::get('username'),
			'email'    => Input::get('email'),
			'password' => Hash::make(Input::get('password'))
			));

		return Redirect::to('/')->with('success', 'Thanks for registering!');

	} else {
		return $validator->getMessageBag();
	}
});


Route::get('log/add', function()
{
	return View::make('add');
});

Route::post('log/add', 'LogController@addEntry');
