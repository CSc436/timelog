<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLogCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('log_category', function(Blueprint $table) {
			$table->boolean('isTask');
			$table->dateTime('deadline')->nullable();
			$table->boolean('isCompleted');
			$table->integer('rating');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('log_category', function(Blueprint $table) {$table->dropColumn('isTask');});
		Schema::table('log_category', function(Blueprint $table) {$table->dropColumn('deadline');});
		Schema::table('log_category', function(Blueprint $table) {$table->dropColumn('isCompleted');}); 
		Schema::table('log_category', function(Blueprint $table) {$table->dropColumn('rating');});
	}

}
