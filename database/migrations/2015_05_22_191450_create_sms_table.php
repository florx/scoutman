<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');

            $table->integer('sms_from_id')->unsigned()->index();
            $table->foreign('sms_from_id')->references('id')->on('sms_froms')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->text('content');
            $table->dateTime('schedule');

			$table->timestamps();
		});

        Schema::create('sms_youth', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('sms_id')->unsigned()->index();
            $table->foreign('sms_id')->references('id')->on('sms')->onDelete('cascade');

            $table->integer('youth_id')->unsigned()->index();
            $table->foreign('youth_id')->references('id')->on('youths')->onDelete('cascade');

            $table->string('status')->default('Queued');

            $table->timestamps();
        });

        Schema::create('sms_youth_parent', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('sms_id')->unsigned()->index();
            $table->foreign('sms_id')->references('id')->on('sms')->onDelete('cascade');

            $table->integer('youth_parent_id')->unsigned()->index();
            $table->foreign('youth_parent_id')->references('id')->on('youth_parents')->onDelete('cascade');

            $table->string('status')->default('Queued');

            $table->timestamps();
        });

        Schema::create('sms_user', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('sms_id')->unsigned()->index();
            $table->foreign('sms_id')->references('id')->on('sms')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('status')->default('Queued');

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
        Schema::drop('sms_youth');
        Schema::drop('sms_youth_parent');
        Schema::drop('sms_user');
		Schema::drop('sms');

	}

}
