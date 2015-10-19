<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CubBadgesUpload extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\App\Badge::loadFromCSV('/app/CubBadgesUpload_BadgeList.csv');
        \App\BadgeRequirement::loadFromCSV('/app/CubBadgesUpload_Requirements.csv');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
