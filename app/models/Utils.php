<?php

class Utils{

	public static function validateName($name){
		$validchars = preg_match('/^[a-zA-z0-9-_ \.\'"\+\*\?&\]\[\}\{\|\(\)\$%\^#!@~]+$/', $name);
			if($validchars == 0 OR $validchars === false)
				return false;
			return count(str_replace(' ','',$name)) > 0;
	}

	public static function validateColor($color){
		//$validchars = true;
		$validchars = preg_match('/([0-9a-fA-F]{6})/', $color);
			if($validchars == 0 OR $validchars === false)
				return false;
			return count(str_replace(' ','',$color)) > 0;
	}
}