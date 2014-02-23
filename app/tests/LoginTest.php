<?php

class LoginTest extends TestCase{
	
	public function testLogin(){

		// test for logging in a user

		$post_data = array('username'=>'mknatz', 'password'=>'mknatz');

		Input::replace($post_data);
		$check = Input::get();
		echo $check['username'];
		echo "\n\n";
		
		$response = $this->call('POST', 'login');
		echo $response;
	}

}