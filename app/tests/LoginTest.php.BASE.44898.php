<?php

class LoginTest extends TestCase{
	
	public function testLogin(){

		// test for logging in a user

		$post_data = array('username'=>'gopal', 'password'=>'abcd');

		Input::replace($post_data);

		$reponse = $this->call('POST', 'login');

		echo Auth::user();
	}

}