<?php


// This fill will contain ALL the REST API routes that we will be using in Time Log

// Ensure all REST API requests are authenticated

Route::group(array('prefix' => 'api', 'before' => 'auth'), function(){


	Route::get('log/category/{cid}', function($cid)
	{
		$data = DB::select("select DATE_FORMAT(startDateTime,'%m-%d-%y') as label, duration as value from log_entry where cid = $cid order by label asc, duration desc");
		return $data;
	});

	Route::get('log/pie', function()
	{
		// select name, color, duration from log_entry e, log_category c where c.cid = e.cid and c.uid = e.uid
		$data = DB::select("select name as label, CAST(SUM(duration) as unsigned) as value , color as color from log_category c, log_entry e where c.cid = e.cid group by label");
		return $data;
	});

	Route::get('log/data', function()
	{ 
		$data = DB::select("select DATE_FORMAT(startDateTime,'%m-%d-%y') as label, duration as value from log_entry order by label asc, duration desc");
		return $data;
	});

	Route::get('log/categories', function()
	{
		$data = DB::table('log_category')->select('name')->where('uid', '=', Auth::user()->id)->get();
		return $data;
	});

});

?>

