<?php

class LoginTest extends TestCase{
	
	public function testLogin(){

		// test for logging in a user

		$post_data = array('username'=>'timeloguser@gmail.com', 'password'=>'secure password');

		Input::replace($post_data);
<<<<<<< HEAD

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
=======
		$check = Input::get();
		$this->assertEquals($check['username'], 'timeloguser@gmail.com');
		$this->assertEquals($check['password'], 'secure password');
		echo "\n\n";
		
		$response = $this->call('POST', 'login');
		
		echo $response;
>>>>>>> 029aefb3618955ae502a923005cbbd8c97c7ac3a
	}

}