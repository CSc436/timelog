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

        $this->call('UserTableSeeder');
        $this->command->info('User table seeded!');
        $this->call('LogEntrySeeder');
        $this->command->info('log_entry table seeded!');
        $this->call('LogCategorySeeder');
        $this->command->info('log_category table seeded!');
		// $this->call('UserTableSeeder');
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

class LogEntrySeeder extends Seeder {

	public function run() {
		DB::table('log_entry')->delete();

		$userSelect = DB::table('user')->where('email', 'test@test.com')->pluck('id');


		/* log for FEB 03rd, 2014. All logs are under the user 'test@test.com' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-03 04:30:00.000000', 'endDateTime'=> '2014-02-03 04:45:00.004444', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-03 04:45:00.000000', 'endDateTime'=> '2014-02-03 05:45:00.004444', 'notes'=>'test', 'duration'=> '60'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-03 05:45:00.000000', 'endDateTime'=> '2014-02-03 06:00:00.004444', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-03 06:00:00.000000', 'endDateTime'=> '2014-02-03 06:45:00.004444', 'notes'=>'test', 'duration'=> '45'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-03 06:45:00.000000', 'endDateTime'=> '2014-02-03 07:15:00.004444', 'notes'=>'test', 'duration'=> '30'));

		/* log for FEB 04th, 2014. All logs are under the user 'test@test.com' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-04 04:30:00.000000', 'endDateTime'=> '2014-02-04 05:00:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-04 05:00:00.000000', 'endDateTime'=> '2014-02-04 05:30:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-04 05:30:00.000000', 'endDateTime'=> '2014-02-04 06:30:00.000000', 'notes'=>'test', 'duration'=> '60'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-04 06:30:00.000000', 'endDateTime'=> '2014-02-04 06:45:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-04 06:45:00.000000', 'endDateTime'=> '2014-02-04 07:00:00.000000', 'notes'=>'test', 'duration'=> '15'));

		/* log for FEB 05th, 2014. All logs are under the user 'test@test.com' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-05 07:00:00.000000', 'endDateTime'=> '2014-02-05 07:30:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-05 07:45:00.000000', 'endDateTime'=> '2014-02-05 08:30:00.000000', 'notes'=>'test', 'duration'=> '45'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-05 08:30:00.000000', 'endDateTime'=> '2014-02-05 08:45:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-05 08:45:00.000000', 'endDateTime'=> '2014-02-05 09:00:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-05 09:00:00.000000', 'endDateTime'=> '2014-02-05 09:15:00.000000', 'notes'=>'test', 'duration'=> '15'));

		/* log for FEB 06th, 2014. All logs are under the user 'test@test.com' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 09:00:00.000000', 'endDateTime'=> '2014-02-06 09:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 09:15:00.000000', 'endDateTime'=> '2014-02-06 09:30:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 09:30:00.000000', 'endDateTime'=> '2014-02-06 10:45:00.000000', 'notes'=>'test', 'duration'=> '75'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 10:45:00.000000', 'endDateTime'=> '2014-02-06 12:00:00.000000', 'notes'=>'test', 'duration'=> '75'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 12:30:00.000000', 'endDateTime'=> '2014-02-06 14:00:00.000000', 'notes'=>'test', 'duration'=> '90'));

		/* log for FEB 06th, 2014. All logs are under the user 'test@test.com' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-07 12:30:00.000000', 'endDateTime'=> '2014-02-07 14:00:00.000000', 'notes'=>'test', 'duration'=> '90'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 14:30:00.000000', 'endDateTime'=> '2014-02-06 15:00:00.000000', 'notes'=>'test', 'duration'=> '30'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 15:30:00.000000', 'endDateTime'=> '2014-02-06 16:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 15:30:00.000000', 'endDateTime'=> '2014-02-06 16:15:00.000000', 'notes'=>'test', 'duration'=> '15'));
		LogEntry::create(array('uid'=> $userSelect, 'startDateTime' => '2014-02-06 16:30:00.000000', 'endDateTime'=> '2014-02-06 17:15:00.000000', 'notes'=>'test', 'duration'=> '45'));


	}
}

class LogCategorySeeder extends Seeder {

	public function run() {
		DB::table('log_category')->delete();
		
		$userSelect = DB::table('user')->where('email', 'test@test.com')->pluck('id');

		/* Create Categories */
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Homework', 'color' => '#F00'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Sleep', 'color' => '#FF0'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Social', 'color' => '#F0F'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Work', 'color' => '#0FF'));
		LogCategory::create(array('uid' => $userSelect, 'name' => 'Misc', 'color' => '#0F0'));

		$homeworkSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Homework')->pluck('cid');
		$sleepSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Sleep')->pluck('cid');
		$socialSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Social')->pluck('cid');
		$workSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Work')->pluck('cid');
		$miscSelect = DB::table('log_category')->where('uid', $userSelect)->where('name', 'Misc')->pluck('cid');
		
		/* Log Entries with Categories */
		/* log for MAR 03rd, 2014. All logs are under the user 'test' with the password 'password' */
		LogEntry::create(array('uid'=> $userSelect, 'cid' => $homeworkSelect, 'startDateTime' => '2014-03-03 04:30:00.000000', 'endDateTime'=> '2014-03-03 04:45:00.004444', 'notes'=>'test', 'duration'=> '15'));
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
	}
}