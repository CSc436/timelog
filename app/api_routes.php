<?php


// This fill will contain ALL the REST API routes that we will be using in Time Log

// Ensure all REST API requests are authenticated

Route::group(array('prefix' => 'api', 'before' => 'auth'), function(){


	Route::get('log/data/{cid}/{time}', function($cid, $time)
	{
		// $data = DB::select("select DATE_FORMAT(startDateTime,'%m-%d-%y') as label, duration as value from log_entry where cid = $cid order by label asc, duration desc");
		$data = DB::table('log_entry');

		if($time == 1) { // Days
			$data = $data->select(DB::raw('DATE_FORMAT(startDateTime,\'%m-%d-%y\') as label'), 'duration AS value');
		} elseif($time == 2) { // Months
			$data = $data->select(DB::raw('DATE_FORMAT(startDateTime,\'%M-%Y\') as label'), 'duration AS value');
		} elseif($time == 3) { // Years
			$data = $data->select(DB::raw('DATE_FORMAT(startDateTime,\'%Y\') as label'), 'duration AS value');
		}

		if($cid != -1) // If there is no category selected, then print all data
			$data = $data->where('cid', '=', "$cid");

		$data = $data->where('log_entry.uid', '=', Auth::user()->id); // Data matches user

		if($time < 3) // If there is a month in the data, sort first by month
			$data = $data->orderBy(DB::RAW('MONTH(startDateTime)'), 'asc');
		if($time <= 3) // Sort by year
			$data = $data->orderBy(DB::RAW('YEAR(startDateTime)'), 'asc');

		$data = $data->orderBy('duration', 'desc')->get();
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

	Route::get('log/categories', function()
	{
		$data = DB::table('log_category')->select('cid', 'name')->where('uid', '=', Auth::user()->id)->get();
		return $data;
	});
});

?>

