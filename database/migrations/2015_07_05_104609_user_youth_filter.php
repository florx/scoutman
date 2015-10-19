<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserYouthFilter extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function($table)
        {
            $table->integer('filter_section_id')->unsigned()->index()->nullable();
            $table->foreign('filter_section_id')->references('id')->on('sections');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table)
        {
            $table->dropForeign('users_filter_section_id_foreign');
            $table->dropColumn('filter_section_id');
        });
	}

}
