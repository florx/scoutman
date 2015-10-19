<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurgeriesTable extends \Helpers\ScoutManMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surgeries', function(Blueprint $table)
		{
			$table->increments('id');
            $this->addAddress($table);
            $table->string('telephone');
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
		Schema::drop('surgeries');
	}

}
