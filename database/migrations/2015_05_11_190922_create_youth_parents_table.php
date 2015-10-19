<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYouthParentsTable extends Helpers\ScoutManMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('youth_parents', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob')->nullable();
            $table->enum('gender', array('M','F'));
            $table->string('relationship')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('occupation')->nullable();
            $this->addAddress($table);
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
		Schema::drop('youth_parents');
	}

}
