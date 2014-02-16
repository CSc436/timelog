<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddlogForeignkeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// PID: drop old column
		Schema::table('log_category', function(Blueprint $t){$t->dropColumn('PID');});
		
		// CID: drop old column
		Schema::table('log_entry', function(Blueprint $t){$t->dropColumn('CID');});
		
		// make PID and CID nullable and unsigned
		Schema::table('log_category', function(Blueprint $t){$t->integer('PID')->nullable()->unsigned()->after('CID');});
		Schema::table('log_entry', function(Blueprint $t){$t->integer('CID')->nullable()->unsigned()->after('UID');});
		
		// add PID index
		Schema::table('log_category', function(Blueprint $t){$t->index('PID');});
		// add PID's foreign key
		Schema::table('log_category', function(Blueprint $t){$t->foreign('PID')->references('CID')->on('log_category')->onDelete('set null');});
		
		// add CID index
		Schema::table('log_entry', function(Blueprint $t){$t->index('CID');});
		// add CID's foreign key
		Schema::table('log_entry', function(Blueprint $t){$t->foreign('CID')->references('CID')->on('log_category')->onDelete('set null');});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// remove PID's foreign key
		Schema::table('log_category', function(Blueprint $t){$t->dropForeign("log_category_pid_foreign");});
		// remove PID's index
		Schema::table('log_category', function(Blueprint $t){$t->dropIndex("log_category_pid_index");});
		
		// remove CID's foreign key
		Schema::table('log_entry', function(Blueprint $t){$t->dropForeign("log_entry_cid_foreign");});
		// remove CID's index
		Schema::table('log_entry', function(Blueprint $t){$t->dropIndex("log_entry_cid_index");});
		
		// PID: drop new column
		Schema::table('log_category', function(Blueprint $t){$t->dropColumn('PID');});
		
		// CID: drop new column
		Schema::table('log_entry', function(Blueprint $t){$t->dropColumn('CID');});
		
		// make PID and CID not nullable
		Schema::table('log_category', function(Blueprint $t){$t->integer('PID')->after('CID');});
		Schema::table('log_entry', function(Blueprint $t){$t->integer('CID')->after('UID');});
	}

}
