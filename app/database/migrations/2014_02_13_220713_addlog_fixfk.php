<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddlogFixfk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// UID: drop old columns
		Schema::table('log_category', function(Blueprint $t){$t->dropColumn('UID');});
		Schema::table('log_entry', function(Blueprint $t){$t->dropColumn('UID');});
		
		// UID: make new unsigned columns
		Schema::table('log_category', function(Blueprint $t){$t->integer('UID')->unsigned()->after('CID');});
		Schema::table('log_entry', function(Blueprint $t){$t->integer('UID')->unsigned()->after('CID');});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// UID: drop new columns
		Schema::table('log_category', function(Blueprint $t){$t->dropColumn('UID');});
		Schema::table('log_entry', function(Blueprint $t){$t->dropColumn('UID');});
		
		// UID: make old signed columns
		Schema::table('log_category', function(Blueprint $t){$t->integer('UID')->after('CID');});
		Schema::table('log_entry', function(Blueprint $t){$t->integer('UID')->after('CID');});
	}

}
