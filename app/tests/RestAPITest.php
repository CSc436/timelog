<?php

class RestAPITest extends TestCase {

	public function setUp(){

		parent::setUp();
	}

	public function testLogView(){

		$crawler = $this->client->request('GET', '/api/log/pie');
		// $this->assertRedirectedTo('/login');
		// $this->assertRedirectedTo('/login');

	}

	public function testLogPie()
	{
		
	}

}