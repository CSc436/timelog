<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUsername extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		/*
		Schema::table('user', function($table)
		{
    		$table->dropUnique('user_username_unique');
		});
		*/
		Schema::table('user', function($table)
		{
    		$table->dropColumn('username');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		// Note, adding an index for username_unique still needed if we refresh. It's currently not implemented here
		// because it causes problems when we try to enforce a unique constraint on a column with null values.
		Schema::table('user', function($table)
		{
    		$table->string('username');
		});
	}

}
