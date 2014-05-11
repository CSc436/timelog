<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// Set appropriate timezone for Tucson, AZ
		date_default_timezone_set('America/Phoenix');

        $this->call('UserTableSeeder');
        $this->command->info('User table seeded!');
        $this->call('LogCategorySeeder');
        $this->command->info('log_category table seeded!');
	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('user')->delete();

        $password = Hash::make('secure password');
        User::create(array('email' => 'timeloguser@gmail.com', 'firstname' => 'timelog', 'lastname' => 'user' , 'password' => $password));

        $password = Hash::make('abcd');
        User::create(array('email' => 'barshats@gmail.com', 'firstname' => 'Gopal', 'lastname' => 'Adhikari', 'password' => $password));

        $password = Hash::make('password');
        User::create(array('email' => 'test@test.com', 'firstname' => 'testF', 'lastname' => 'testL', 'password' => $password));
    }
}

class LogCategorySeeder extends Seeder {

	public function run() {

		DB::table('log_category')->delete();
		
		$userSelect = DB::table('user')->where('email', 'test@test.com')->pluck('id');

		/* Create Categories */
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Homework', 'color' => 'FFFF00'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Sleep', 'color' => 'FFFF00'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Social', 'color' => 'FF00FF'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Work', 'color' => '00FFFF'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Misc', 'color' => '00FF00'));

		$homeworkSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Homework')->pluck('cid');
		$sleepSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Sleep')->pluck('cid');
		$socialSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Social')->pluck('cid');
		$workSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Work')->pluck('cid');
		$miscSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Misc')->pluck('cid');

		LogCategory::create(array('uid' => $userSelect, 'name' => 'CS 425 HW', 'color' => '#F00', 'pid' => $homeworkSelect ));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'CS 452 HW', 'color' => '#F00', 'pid' => $homeworkSelect ));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'CS 436 HW', 'color' => '#F00', 'pid' => $homeworkSelect ));

		$homework425 = DB::table('log_category')->where('uid', $userSelect)->where('name', 'CS 425 HW')->pluck('cid');

		LogCategory::create(array('uid' => $userSelect, 'name' => 'program 2 from hell', 'color' => '#F00', 'pid' => $homework425 ));

		/* Tasks */

		LogCategory::create(array('uid' => $userSelect, 'name' => 'Finish CS Homework by Friday', 'isTask' => '1', 'deadline' => '2014-05-02 04:45:00.004444'));
		LogCategory::create(array('uid' => $userSelect, 'name' => '452 Final Project', 'isTask' => '1', 'deadline' => '2014-05-07 04:45:00.004444'));
		LogCategory::create(array('uid' => $userSelect, 'name' => '425 Final Project', 'isTask' => '1', 'deadline' => '2014-05-07 04:45:00.004444', 'isCompleted' => '1', 'rating' => '2'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Learn Salsa Dancing', 'isTask' => '1', 'deadline' => '2014-06-02 04:45:00.004444', 'isCompleted' => '1', 'rating' => '3'));
		
		/* Log Entries with Categories */

		/* log for MAR 03rd, 2014. All logs are under the user 'test' with the password 'password' */

		$currDateTime = new DateTime();
		$strStartDate = date_format($currDateTime, 'Y-m-d H:i');
		$strEndDate = date('Y-m-d H:i', strtotime("+50 minutes"));

		echo $strStartDate."\n";
		echo $strEndDate."\n";

		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => $strStartDate, 'endDateTime'=> $strEndDate, 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-03-03 04:45:00.000000', 'endDateTime'=> '2014-03-03 05:45:00.004444', 'notes'=>'test', 'duration'=> '60'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-03-03 05:45:00.000000', 'endDateTime'=> '2014-03-03 06:00:00.004444', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-03-03 06:00:00.000000', 'endDateTime'=> '2014-03-03 06:45:00.004444', 'notes'=>'test', 'duration'=> '45'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-03-03 06:45:00.000000', 'endDateTime'=> '2014-03-03 07:15:00.004444', 'notes'=>'test', 'duration'=> '30'));

		/* log for MAR 04th, 2014. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2014-03-04 04:30:00.000000', 'endDateTime'=> '2014-03-04 05:00:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2014-03-04 05:00:00.000000', 'endDateTime'=> '2014-03-04 05:30:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2014-03-04 05:30:00.000000', 'endDateTime'=> '2014-03-04 06:30:00.000000', 'notes'=>'test', 'duration'=> '60'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2014-03-04 06:30:00.000000', 'endDateTime'=> '2014-03-04 06:45:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2014-03-04 06:45:00.000000', 'endDateTime'=> '2014-03-04 07:00:00.000000', 'notes'=>'test', 'duration'=> '15'));

		/* log for MAR 05th, 2014. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2014-03-05 07:00:00.000000', 'endDateTime'=> '2014-03-05 07:30:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2014-03-05 07:45:00.000000', 'endDateTime'=> '2014-03-05 08:30:00.000000', 'notes'=>'test', 'duration'=> '45'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2014-03-05 08:30:00.000000', 'endDateTime'=> '2014-03-05 08:45:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2014-03-05 08:45:00.000000', 'endDateTime'=> '2014-03-05 09:00:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2014-03-05 09:00:00.000000', 'endDateTime'=> '2014-03-05 09:15:00.000000', 'notes'=>'test', 'duration'=> '15'));

		/* log for MAR 06th, 2014. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2014-03-06 09:00:00.000000', 'endDateTime'=> '2014-03-06 09:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2014-03-06 09:15:00.000000', 'endDateTime'=> '2014-03-06 09:30:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2014-03-06 09:30:00.000000', 'endDateTime'=> '2014-03-06 10:45:00.000000', 'notes'=>'test', 'duration'=> '75'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2014-03-06 10:45:00.000000', 'endDateTime'=> '2014-03-06 12:00:00.000000', 'notes'=>'test', 'duration'=> '75'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2014-03-06 12:30:00.000000', 'endDateTime'=> '2014-03-06 14:00:00.000000', 'notes'=>'test', 'duration'=> '90'));

		/* log for MAR 06th, 2014. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2014-03-07 12:30:00.000000', 'endDateTime'=> '2014-03-07 14:00:00.000000', 'notes'=>'test', 'duration'=> '90'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2014-03-06 14:30:00.000000', 'endDateTime'=> '2014-03-06 15:00:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2014-03-06 15:30:00.000000', 'endDateTime'=> '2014-03-06 16:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2014-03-06 15:30:00.000000', 'endDateTime'=> '2014-03-06 16:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2014-03-06 16:30:00.000000', 'endDateTime'=> '2014-03-06 17:15:00.000000', 'notes'=>'test', 'duration'=> '45'));

		/* Variable Months and Years */
		/* log for 2014. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-03-03 04:30:00.000000', 'endDateTime'=> '2014-03-03 05:45:00.004444', 'notes'=>'test', 'duration'=> '75'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-04-03 04:45:00.000000', 'endDateTime'=> '2014-04-03 06:45:00.004444', 'notes'=>'test', 'duration'=> '120'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-05-03 05:45:00.000000', 'endDateTime'=> '2014-05-03 06:00:00.004444', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-06-03 06:00:00.000000', 'endDateTime'=> '2014-06-03 06:50:00.004444', 'notes'=>'test', 'duration'=> '50'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-07-03 06:45:00.000000', 'endDateTime'=> '2014-07-03 07:15:00.004444', 'notes'=>'test', 'duration'=> '30'));

		/* log for 2015. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2015-08-04 03:30:00.000000', 'endDateTime'=> '2015-08-04 05:00:00.000000', 'notes'=>'test', 'duration'=> '90'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2015-09-04 04:00:00.000000', 'endDateTime'=> '2015-09-04 05:15:00.000000', 'notes'=>'test', 'duration'=> '45'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2015-10-04 05:30:00.000000', 'endDateTime'=> '2015-10-04 06:30:00.000000', 'notes'=>'test', 'duration'=> '60'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2015-11-04 07:30:00.000000', 'endDateTime'=> '2015-11-04 08:00:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $socialSelect, 'startDateTime' => '2015-12-04 06:45:00.000000', 'endDateTime'=> '2015-12-04 07:00:00.000000', 'notes'=>'test', 'duration'=> '15'));

		/* log for 2016. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2016-01-05 07:00:00.000000', 'endDateTime'=> '2016-01-05 07:30:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2016-02-05 07:45:00.000000', 'endDateTime'=> '2016-02-05 08:30:00.000000', 'notes'=>'test', 'duration'=> '45'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2016-03-05 08:30:00.000000', 'endDateTime'=> '2016-03-05 08:45:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2016-04-05 08:45:00.000000', 'endDateTime'=> '2016-04-05 09:00:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $workSelect, 'startDateTime' => '2016-05-05 09:00:00.000000', 'endDateTime'=> '2016-05-05 09:15:00.000000', 'notes'=>'test', 'duration'=> '15'));

		/* log for 2017. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2017-03-06 09:00:00.000000', 'endDateTime'=> '2017-03-06 09:30:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2017-03-06 09:15:00.000000', 'endDateTime'=> '2017-03-06 09:30:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2017-03-06 09:30:00.000000', 'endDateTime'=> '2017-03-06 10:45:00.000000', 'notes'=>'test', 'duration'=> '75'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2017-03-06 10:45:00.000000', 'endDateTime'=> '2017-03-06 12:00:00.000000', 'notes'=>'test', 'duration'=> '75'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $sleepSelect, 'startDateTime' => '2017-03-06 12:30:00.000000', 'endDateTime'=> '2017-03-06 14:00:00.000000', 'notes'=>'test', 'duration'=> '90'));

		/* log for 2018. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2018-03-07 12:30:00.000000', 'endDateTime'=> '2018-03-07 14:00:00.000000', 'notes'=>'test', 'duration'=> '90'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2018-03-06 14:30:00.000000', 'endDateTime'=> '2018-03-06 15:00:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2018-03-06 15:30:00.000000', 'endDateTime'=> '2018-03-06 16:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2018-03-06 15:30:00.000000', 'endDateTime'=> '2018-03-06 16:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $miscSelect, 'startDateTime' => '2018-03-06 16:30:00.000000', 'endDateTime'=> '2018-03-06 17:15:00.000000', 'notes'=>'test', 'duration'=> '45'));
	}
}