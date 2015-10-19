<?php

use App\Disability;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisabilitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('disabilities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

        $disabilities = array('Developmental','Injury','Physical','Medical','Mental health','Progressive','Sensory');
        foreach($disabilities as $disability){
            Disability::forceCreate(['name' => $disability]);
        }

        Schema::create('disability_youth', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('youth_id')->unsigned()->index();
            $table->foreign('youth_id')->references('id')->on('youths')->onDelete('cascade');

            $table->integer('disability_id')->unsigned()->index();
            $table->foreign('disability_id')->references('id')->on('disabilities')->onDelete('cascade');
            $table->timestamps();
        });


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('disability_youth');
		Schema::drop('disabilities');
	}

}
