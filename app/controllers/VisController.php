<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VisController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Visualization Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles visualization, including charts and filter options
	|
	*/

	public function visualize(){

		$date = explode("/", Input::get('dates'));
		$id = Auth::user()->id;
		$categories = DB::select("select name, cid from log_category c where c.uid = $id");
		$timeFrame = DB::select("select YEAR(startDateTime) as year, MONTH(startDateTime) as month from log_entry GROUP BY YEAR(startDateTime), MONTH(startDateTime) ORDER BY YEAR(startDateTime), MONTH(startDateTime)");
		$selectedMonth = array();
		$selectedMonth["0/0"] = "-----";
		foreach ($timeFrame as $time) {
			$selectedMonth[$time->month."/".$time->year] = $time->month."/".$time->year;
		}

		// default value
		$startDT = strtotime('today -8 weeks');
		$endDT = strtotime('today');

		if(Input::has('start'))
			$startDT = strtotime(Input::get('start').' 00:00:00');

		if(Input::has('end'))
			$endDT = strtotime(Input::get('end').' 23:59:59');

		$startRange = date('Y-m-d 00:00:00', $startDT);
		$endRange = date('Y-m-d 23:59:59', $endDT);

		$table_rows = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select('LID','log_entry.CID','color', 'name', 'startDateTime', 'endDateTime', 'duration', 'notes')
				->where('log_entry.uid', '=', "$id")
				->where('startDateTime', '>=', $startRange)
				->where('endDateTime', '<=', $endRange)
				->orderBy('startDateTime','ASC')
				->get();

		$chart_rows = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select(DB::RAW("`log_entry`.`CID`, `name`, `color`, SUM(`duration`) AS 'duration', MIN(`startDateTime`) AS 'startDateTime'")) //, COUNT(`LID`) AS 'count'"))
				->where('log_entry.uid', '=', $id)
				->where('startDateTime', '>=', $startRange)
				->where('endDateTime', '<=', $endRange)
				->groupBy('log_entry.CID')
				->groupBy(DB::RAW("YEAR(startDateTime)"))
				->groupBy(DB::RAW("MONTH(startDateTime)"))
				->groupBy(DB::RAW("DAY(startDateTime)"))
				->orderBy('startDateTime','ASC')
				->get();

		$todayStart = strtotime('yesterday 12:00') * 1000;
		$todayEnd = strtotime('today 12:00') * 1000;

		$sendToView = array(
			'table_rows' => $table_rows,
			'chart_rows' => $chart_rows,
			'categories' => $categories,
			'dates' => $selectedMonth,
			// for dates ranges filter
			'startDT' => $startDT,
			'endDT' => $endDT,
			// for highlighting today's date on the chart
			'todayStart' => $todayStart,
			'todayEnd' => $todayEnd,
			// for the top tab
			'active' =>'viewlog'
		);

		return View::make('view')->with($sendToView);
	}

}
