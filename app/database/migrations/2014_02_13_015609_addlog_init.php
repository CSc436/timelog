<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddlogInit extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log_category', function(Blueprint $t)
		{
			// auto increment id (primary key)
			$t->increments('CID'); // Category ID
			$t->integer('PID'); // Parent ID
			$t->integer('UID'); // User ID
			$t->string('name');
			$t->string('color', 6);
		});
		Schema::create('log_entry', function(Blueprint $t)
		{
			// auto increment id (primary key)
			$t->increments('LID'); // Log ID
			$t->integer('UID'); // User ID
			$t->integer('CID'); // Category ID
			$t->dateTime('startDateTime');
			$t->dateTime('endDateTime');
			$t->integer('duration');
			$t->text('notes');
		});/*
		Schema::table('log_category', function(Blueprint $t)
		{
			
			// foreign key
			$t->foreign('PID')->references('CID')->on('log_category');
		});
		Schema::table('log_entry', function(Blueprint $t)
		{
			
			// foreign key
			$t->foreign('CID')->references('CID')->on('log_category');
			
		});*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('log_entry');
		Schema::drop('log_category');
	}

}