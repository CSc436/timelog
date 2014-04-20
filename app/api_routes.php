<?php


// This fill will contain ALL the REST API routes that we will be using in Time Log

// Ensure all REST API requests are authenticated

Route::group(array('prefix' => 'api', 'before' => 'auth'), function(){


	Route::get('log/category/{cid}', function($cid)
	{
		// $data = DB::select("select DATE_FORMAT(startDateTime,'%m-%d-%y') as label, duration as value from log_entry where cid = $cid order by label asc, duration desc");
		$data = DB::table('log_entry')
			->select(DB::raw('DATE_FORMAT(startDateTime,\'%m-%d-%y\') as label'), 'duration AS value')
			->where('cid', '=', "$cid")
			->orderBy('label', 'asc')
			->orderBy('duration', 'desc')->get();
		return $data;
	});

	Route::get('log/pie', function()
	{
		// $data = DB::select("select name as label, CAST(SUM(duration) as unsigned) as value , color as color from log_category c, og_entry e where c.cid = e.cid group by label");
		$data = DB::table('log_entry')
			->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
			->select('name AS label', DB::raw('CAST(SUM(duration) as unsigned) as value'), 'color')
			->where('log_entry.uid', '=', Auth::user()->id)
			->groupBy('label')->get();
		return $data;
	});

	Route::get('log/data', function()
	{ 
		// $data = DB::select("select DATE_FORMAT(startDateTime,'%m-%d-%y') as label, duration as value from log_entry order by label asc, duration desc");
		$data = DB::table('log_entry')
			->select(DB::raw('DATE_FORMAT(startDateTime,\'%m-%d-%y\') as label'),'duration AS value')
			->where('log_entry.uid', '=', Auth::user()->id)
			->orderBy('label', 'asc')
			->orderBy('duration', 'desc')->get();
		return $data;
	});

	Route::get('log/categories', function()
	{
		$data = DB::table('log_category')->select('cid', 'name')->where('uid', '=', Auth::user()->id)->get();
		return $data;
	});

});

?>

