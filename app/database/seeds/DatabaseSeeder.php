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
		// $this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('user')->delete();

        $password = Hash::make('secure password');
        User::create(array('email' => 'timeloguser@gmail.com', 'firstname' => 'timelog', 'lastname' => 'user', 'username' => 'timeloguser', 'password' => $password));

        $password = Hash::make('abcd');
        User::create(array('email' => 'barshats@gmail.com', 'firstname' => 'Gopal', 'lastname' => 'Adhikari', 'username' => 'gopal', 'password' => $password));
    }
}