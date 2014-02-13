<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('/users', function()
{
	return "<h1>Hello World!</h1>";
});

Route::get('about', function()
{
	return View::make('about');
});

Route::get('contact', function()
{
	return View::make('contact');
});

Route::get('login', function()
{
	return View::make('login');
});

Route::get('log/add', function()
{
	return View::make('add');
});

Route::post('log/add', 'LogController@addEntry');