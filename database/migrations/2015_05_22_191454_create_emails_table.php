<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('emails', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('email_from_id')->unsigned()->index();
            $table->foreign('email_from_id')->references('id')->on('email_froms')->onDelete('cascade');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->text('subject');
            $table->text('content');
            $table->text('attachments');
            $table->dateTime('schedule');

            $table->timestamps();
        });

        Schema::create('email_youth', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

            $table->integer('youth_id')->unsigned()->index();
            $table->foreign('youth_id')->references('id')->on('youths')->onDelete('cascade');

            $table->string('status')->default('Queued');

            $table->timestamps();
        });

        Schema::create('email_youth_parent', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

            $table->integer('youth_parent_id')->unsigned()->index();
            $table->foreign('youth_parent_id')->references('id')->on('youth_parents')->onDelete('cascade');

            $table->string('status')->default('Queued');

            $table->timestamps();
        });

        Schema::create('email_user', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->integer('email_id')->unsigned()->index();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');

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
        Schema::drop('email_youth');
        Schema::drop('email_youth_parent');
        Schema::drop('email_user');
		Schema::drop('emails');
	}

}
