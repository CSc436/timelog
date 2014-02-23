<?php

class UserTest extends TestCase {

	public function testNewUser()
	{
		// test for creating new user

		$post_data = array('username'=>'jdoe', 'firstname'=>'Jane', 'lastname'=>'Doe', 
			'email'=>'jdoe@example.com', 'password'=>'abcd',
			'password_confirmation'=>'abcd');

		Input::replace($post_data);

		$this->call('POST', 'signup');

		$user = User::all();
		// echo $user;
	}

}