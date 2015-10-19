<?php

use App\Faith;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaithsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faiths', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
			$table->timestamps();
		});

        $faiths = array('Buddhist', 'Christian', 'Hindu', 'Jewish', 'Muslim', 'Sikh', 'Any Other Religion', 'No religion', 'Prefer not to say');
        foreach($faiths as $faith){
            Faith::forceCreate(['name' => $faith]);
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('faiths');
	}

}
