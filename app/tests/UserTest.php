<?php

class UserTest extends TestCase {

	public function test()
	{
		// test for creating new user
		$this->call('POST', 'signup');
	}

}