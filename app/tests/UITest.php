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

}