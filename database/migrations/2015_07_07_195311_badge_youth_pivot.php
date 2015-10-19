<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BadgeYouthPivot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('badge_youth', function($table)
        {
            $table->string('status');
            $table->tinyInteger('plus');
            $table->tinyInteger('instructor');
            $table->dropColumn('achieved_at');
            $table->dropColumn('awarded_at');
        });

        //remove badges without requirements!
        DB::table('badges')->whereIn('id', [5, 6, 7, 8, 9, 10])->delete();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('badge_youth', function($table)
        {
            $table->dropColumn('status');
            $table->dropColumn('plus');
            $table->dropColumn('instructor');
            $table->date('achieved_at');
            $table->date('awarded_at');
        });
	}

}
