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