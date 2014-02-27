<?php

class LoginTest extends TestCase{
	
	public function testLogin(){

		// test for logging in a user

		$post_data = array('username'=>'timeloguser@gmail.com', 'password'=>'secure password');

		Input::replace($post_data);
		$check = Input::get();
		$this->assertEquals($check['username'], 'timeloguser@gmail.com');
		$this->assertEquals($check['password'], 'secure password');
		echo "\n\n";
		
		$response = $this->call('POST', 'login');
		
		echo $response;
	}

}