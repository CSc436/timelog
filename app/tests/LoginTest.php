<?php

class LoginTest extends TestCase{
	
	public function loginGood(){
		$response = $this->call('GET', 'login');
	}

}