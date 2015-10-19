<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYouthsTable extends Helpers\ScoutManMigration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('youths', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('section_id')->unsigned()->nullable();
            $table->foreign('section_id')->references('id')->on('sections');
            $table->string('title');
            $table->string('first_name');
            $table->string('middle_names');
            $table->string('last_name');
            $table->date('dob');
            $this->addAddress($table);
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('patrol_name')->nullable();
            $table->integer('nationality_id')->unsigned()->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities');
            $table->integer('faith_id')->unsigned()->nullable();
            $table->foreign('faith_id')->references('id')->on('faiths');
            $table->integer('ethnicity_id')->unsigned()->nullable();
            $table->foreign('ethnicity_id')->references('id')->on('ethnicities');
            $table->string('doctor_name')->nullable();
            $table->integer('surgery_id')->unsigned()->nullable();
            $table->foreign('surgery_id')->references('id')->on('surgeries');
            $table->string('nhs_number')->nullable();
            $table->text('dietary_needs')->nullable();
            $table->text('disability_notes')->nullable();
            $table->text('medical_info')->nullable();
            $table->tinyInteger('swim');
            $table->tinyInteger('bannedFirearms');
			$table->timestamps();
		});

        Schema::create('youth_youth_parent', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('youth_id')->unsigned()->index();
            $table->foreign('youth_id')->references('id')->on('youths')->onDelete('cascade');

            $table->integer('youth_parent_id')->unsigned()->index();
            $table->foreign('youth_parent_id')->references('id')->on('youth_parents')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('youth_emergency_contact', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('youth_id')->unsigned()->index();
            $table->foreign('youth_id')->references('id')->on('youths')->onDelete('cascade');

            $table->integer('youth_parent_id')->unsigned()->index();
            $table->foreign('youth_parent_id')->references('id')->on('youth_parents')->onDelete('cascade');
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
        Schema::drop('youth_youth_parent');
        Schema::drop('youth_emergency_contact');
		Schema::drop('youths');

	}

}
