<?php

use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('telephone', 15);
			$table->rememberToken();
			$table->timestamps();
		});

        User::forceCreate(['name' => 'Jake Hall', 'email' => 'hall.jake.a@gmail.com', 'password' => Hash::make('password'), 'telephone' => '07506127076']);
        User::forceCreate(['name' => 'Daniel Mercer', 'email' => 'danielmercer@gmail.com', 'password' => Hash::make('password'), 'telephone' => '07817167823']);
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
