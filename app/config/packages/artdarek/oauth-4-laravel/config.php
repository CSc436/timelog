<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array(),
        ),		

        /**
		 * Google
		 */
        'Google' => array(
            'client_id'     => '582425857544-gjjk2k9p0ihhof4jukn00vgi3efq22t3.apps.googleusercontent.com',
            'client_secret' => 'phO8XzV5XxTu6sGe2UubXlvk',
            'scope'         => array('https://www.googleapis.com/auth/calendar.readonly', 'profile', 'email'),
        ),	

	)

);