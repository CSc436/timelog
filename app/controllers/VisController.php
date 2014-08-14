<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VisController extends BaseController {

	var $uid;

	/*
	|--------------------------------------------------------------------------
	| Visualization Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles visualization, including charts and filter options
	|
	*/

	public function visualize(){

		$this->uid = Auth::user()->id;

		// default value
		$startDT = strtotime('today -8 weeks');
		$endDT = strtotime('today');

		if(Input::has('start'))
			$startDT = strtotime(Input::get('start').' 00:00:00');

		if(Input::has('end'))
			$endDT = strtotime(Input::get('end').' 23:59:59');

		$startRange = date('Y-m-d 00:00:00', $startDT);
		$endRange = date('Y-m-d 23:59:59', $endDT);

		if(Input::has('category') && Input::get('category') !== "") {
			//$currentCategory = array(Input::get('category'));
			$categories = DB::select("select name, cid from log_category c where c.uid = ".$this->uid." AND c.pid = ".Input::get('category'));
			//$currentCategory = array();
			$currentCategory = array(Input::get('category'));
			foreach($categories as $cat) {
					// $selectCat[$cat->cid] = $cat->name;
					array_push($currentCategory, $cat->cid);
			}
		}else{
			$categories = DB::select("select name, cid from log_category c where c.uid = ".$this->uid);
			$currentCategory = array();
			foreach($categories as $cat) {
					// $selectCat[$cat->cid] = $cat->name;
					array_push($currentCategory, $cat->cid);
			}
		}

		$table_rows = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select('LID','log_entry.CID','color', 'name', 'startDateTime', 'endDateTime', 'duration', 'notes')
				->where('log_entry.uid', '=', $this->uid)
				->where('startDateTime', '>=', $startRange)
				->where('endDateTime', '<=', $endRange)
				->wherein('log_category.cid', $currentCategory)
				->orderBy('startDateTime','ASC')
				->get();

		$chart_rows = DB::table('log_entry')
				->join('log_category', 'log_entry.cid', '=', 'log_category.cid')
				->select(DB::RAW("`log_entry`.`CID`, `name`, `color`, SUM(`duration`) AS 'duration', MIN(`startDateTime`) AS 'startDateTime'")) //, COUNT(`LID`) AS 'count'"))
				->where('log_entry.uid', '=', $this->uid)
				->where('startDateTime', '>=', $startRange)
				->where('endDateTime', '<=', $endRange)
				->wherein('log_category.cid', $currentCategory)
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
			'categories' => Utils::getSelectCats(),
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
