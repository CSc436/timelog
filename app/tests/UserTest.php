<?php

class UserTest extends TestCase {

	public function setUp(){

		parent::setUp();
		
		Artisan::call('migrate');
		Artisan::call('db:seed');
	}

	public function testNewUserValid(){

		$user = new User;

		$user->firstname = '';
		$user->lastname = 'User'; 
		$user->email = 'something@example.com';
		$user->password='abcd';

		$this->assertTrue($user->save());
		$this->assertTrue($user->save());

	}

	public function testNewUser()
	{
		// test for creating new user

		$post_data = array('username'=>'jdoe', 'firstname'=>'Jane', 'lastname'=>'Doe', 
			'email'=>'jdoe@example.com', 'password'=>'abcd',
			'password_confirmation'=>'abcd');

		Input::replace($post_data);

		$response = $this->action('POST', 'UserController@postNewUser', $post_data);

		$this->assertRedirectedTo("/");
	}

}