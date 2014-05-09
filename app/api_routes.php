<?php


// This fill will contain ALL the REST API routes that we will be using in Time Log

// Ensure all REST API requests are authenticated

Route::group(array('prefix' => 'api', 'before' => 'auth'), function(){

	Route::get('log/categories', function()
	{
		$data = DB::table('log_category')->select('cid', 'name')->where('uid', '=', Auth::user()->id)->get();
		return $data;
	});

	// Returns a HTML view for the modal to add log entry
	Route::get('log/edit/modal', function()
	{
		return View::make('entryform_modal');
	});

	Route::post('log/save/{id?}', 'LogController@saveEntryFromCalendar')->where('id', '[0-9]+');
	
	//Gets the list of tasks overdue
	Route::get('log/tasks/overdue', function()
	{
		$data = DB::table('log_category')
			->select('cid', 'name')
			->where('uid', '=', Auth::user()->id)
			->where('isTask', '=', '1')
			->where('isCompleted', '=', '0')
			->where( 'deadline', '<', DATE(UTC_TIMESTAMP()) )
			->get();
		return $data;
	});

	//Gets the list of tasks
	Route::get('log/tasks', function()
	{
		$data = DB::table('log_category')
			->select('cid', 'name')
			->where('uid', '=', Auth::user()->id)
			->where('isTask', '=', '1')
			->get();
		return $data;
	});

});

?>

