<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('log_category', function(Blueprint $t){$t->timestamps();});
		Schema::table('log_entry', function(Blueprint $t){$t->timestamps();});
		Schema::table('log_entry', function(Blueprint $t){$t->softDeletes();});
		Schema::table('log_category', function(Blueprint $t){$t->softDeletes();});

		// add UID index
		Schema::table('log_category', function(Blueprint $t){$t->index('UID');});
		// add UID's foreign key
		Schema::table('log_category', function(Blueprint $t){$t->foreign('UID')->references('id')->on('user')->onDelete('cascade');});

		// add UID index
		Schema::table('log_entry', function(Blueprint $t){$t->index('UID');});
		// add UID's foreign key
		Schema::table('log_entry', function(Blueprint $t){$t->foreign('UID')->references('id')->on('user')->onDelete('cascade');});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('log_category', function(Blueprint $t){$t->dropColumn('created_at');});
		Schema::table('log_entry', function(Blueprint $t){$t->dropColumn('created_at');});
		Schema::table('log_category', function(Blueprint $t){$t->dropColumn('updated_at');});
		Schema::table('log_entry', function(Blueprint $t){$t->dropColumn('updated_at');});
		Schema::table('log_category', function(Blueprint $t){$t->dropColumn('deleted_at');});
		Schema::table('log_entry', function(Blueprint $t){$t->dropColumn('deleted_at');});

		// remove UID's foreign key
		Schema::table('log_category', function(Blueprint $t){$t->dropForeign("log_category_uid_foreign");});
		// remove UID's index
		Schema::table('log_category', function(Blueprint $t){$t->dropIndex("log_category_uid_index");});

		// remove UID's foreign key
		Schema::table('log_entry', function(Blueprint $t){$t->dropForeign("log_entry_uid_foreign");});
		// remove UID's index
		Schema::table('log_entry', function(Blueprint $t){$t->dropIndex("log_entry_uid_index");});
	}

}
