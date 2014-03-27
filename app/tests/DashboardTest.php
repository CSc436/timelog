<?php

class DashboardTest extends TestCase {
	
	public function testGetting(){

		$post_data = array('email'=>'timeloguser@gmail.com', 'password'=>'secure password');

		Input::replace($post_data);

		$response = $this->action('POST', 'UserController@postUserLogin', $post_data);

		$this->assertNotNull(Auth::check());
		
		$crawler = $this->client->request('GET', '/dashboard');

		$this->assertTrue($this->client->getResponse()->isOk());
	}	
	
}