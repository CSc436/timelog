<?php

class UITest extends TestCase {

	public function testHomepage()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testAbout()
	{
		$crawler = $this->client->request('GET', '/about');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testContact()
	{
		$crawler = $this->client->request('GET', '/contact');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testLogin()
	{
		$crawler = $this->client->request('GET', '/login');

		$this->assertTrue($this->client->getResponse()->isOk());
	}
	
	public function testProfile()
	{
		$crawler = $this->client->request('GET', '/profile');
		
		$this->assertFalse($this->client->getResponse()->isOk());
		
		$post_data = array('email'=>'timeloguser@gmail.com', 'password'=>'secure password');

		Input::replace($post_data);

		$response = $this->call('POST', 'login');
		
		echo $response;
		/*
		$this->assertTrue($this->client->getResponse()->isOk());*/
	}
}