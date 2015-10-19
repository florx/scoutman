<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOccasionalBadges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        \App\BadgeCategory::forceCreate(['section_id' => null, 'name' => 'Occasional badges']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$category = \App\BadgeCategory::whereRaw('name = ? and section_id is null', ['Occasional badges'])->first();
        $category->forceDelete();
	}

}
