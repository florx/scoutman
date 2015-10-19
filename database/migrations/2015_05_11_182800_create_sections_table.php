<?php

use App\Section;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sections', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name', 100);
			$table->timestamps();
		});

        Section::forceCreate(['name' => 'Beavers']);
        Section::forceCreate(['name' => 'Cubs']);
        Section::forceCreate(['name' => 'Scouts']);
        Section::forceCreate(['name' => 'Explorers']);
        //Section::forceCreate(['name' => 'Young Leaders']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sections');
	}

}
