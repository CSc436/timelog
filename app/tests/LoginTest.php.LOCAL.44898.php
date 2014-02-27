<?php

class LoginTest extends TestCase{
	
	public function testLogin(){

		// test for logging in a user

		$post_data = array('username'=>'gopal', 'password'=>'abcd');

		Input::replace($post_data);

		$response = $this->action('POST', 'UserController@postUserLogin', $post_data);

		$loggedInUser = Auth::user();

		$this->assertEquals($loggedInUser->username, "gopal");

		$this->assertNotNull(Auth::check());

		if(Auth::check()){
			echo "The user was successfully logged in";
		}

		$this->assertTrue($response->isRedirect());
		$this->assertRedirectedTo('profile');
	}


	public function testLogout(){

		$response = $this->call('GET', 'logout');
		$this->assertTrue($response->isRedirect());
		$this->assertNull(Auth::user(), 'User\'s session is empty as expected');
		$this->assertRedirectedTo('/');
	}

}