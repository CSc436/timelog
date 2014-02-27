<?php

public class Utils{

	public static function validateName($name){

		$validchars = preg_match('/[a-zA-z0-9-_ \.\'"\+\*\?&\]\[\}\{\|\(\)\$%\^#!@]+/', $name);
			if($validchars === false)
				return false;
			return count(str_replace(' ','',$name)) > 0;
	}
} 