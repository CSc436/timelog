<?php

class Utils{

	public static function validateName($name){
		$validchars = preg_match('/^[a-zA-z0-9-_ \.\'"\+\*\?&\]\[\}\{\|\(\)\$%\^#!@~]+$/', $name);
			if($validchars == 0 OR $validchars === false)
				return false;
			return count(str_replace(' ','',$name)) > 0;
	}

	public static function validateRating($rating){
		$validchars = preg_match('/([1-3]{1})/', $rating);
			if($validchars == 0 OR $validchars === false)
				return false;
			return count(str_replace(' ','',$rating)) > 0;
	}

	public static function validateColor($color){
		//$validchars = true;
		$validchars = preg_match('/([0-9a-fA-F]{6})/', $color);
			if($validchars == 0 OR $validchars === false)
				return false;
			return count(str_replace(' ','',$color)) > 0;
	}

	// Parameters:
	// $cat is the parent category
	// $parentpath is the current legacy path of all parents for these children
	//
	// Returns:
	// This method returns an array of CID->Category Name pairs of the users category tree structure, starting with the provided root $cat.
	public static function getSelectCats($cat = NULL, $parentpath = ""){
		if(!Auth::check())
			return array();

		$selectCat = array();
		$sep = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		if($cat != NULL){
			$fullpath = $parentpath.$cat->name;
			$selectCat[$cat->cid] = $fullpath;
		}
		
		// get children
		$subcats = DB::table('log_category')->select('name', 'cid');

		if($cat == NULL)
			$subcats = $subcats->where('PID', '=', NULL);
		else
			$subcats = $subcats->where('PID', '=', $cat->cid);
		
		$subcats = $subcats->where('UID', '=', Auth::user()->id)
			->orderby('name','ASC')
			->get();

		$selectChildCat = array();
		foreach($subcats as $thissubcat){
			if($cat != NULL)
				$selectChildCat = Utils::getSelectCats($thissubcat, $parentpath.$sep);
			else
				$selectChildCat = Utils::getSelectCats($thissubcat, "");
			$selectCat += $selectChildCat;
		}
		return $selectCat;

	}
}