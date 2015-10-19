<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgeCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('badge_categories', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');

            $table->integer('section_id')->unsigned()->index()->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            $table->string('name');
			$table->timestamps();
		});

        $types = ['Activity badges', 'Challenge awards', 'Core badges'];
        $sections = \App\Section::all();

        foreach($sections as $section) {
            foreach ($types as $type) {
                \App\BadgeCategory::forceCreate(['section_id' => $section->id, 'name' => $type]);
            }
        }

        \App\BadgeCategory::forceCreate(['section_id' => null, 'name' => 'Staged badges']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('badge_categories');
	}

}
