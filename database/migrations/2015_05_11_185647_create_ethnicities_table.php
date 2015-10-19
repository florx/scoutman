<?php

use App\Ethnicity;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEthnicitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ethnicities', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
			$table->timestamps();
		});

        $ethnicities = array('English/Welsh/Scottish/Northern Irish/British', 'Irish', 'Gypsy or Irish Traveler', 'Any other White background', 'White and black Caribbean', 'White and Black African', 'White and Asian', 'Any other mixed or Multiple ethic group', 'Indian', 'Pakistani', 'Bangladeshi', 'Chinese', 'Any other Asian Background', 'African', 'Carribean', 'Any other Black/African/Caribbean background', 'Arab', 'Other', 'Prefer not to say');
        foreach($ethnicities as $ethnicity){
            Ethnicity::forceCreate(['name' => $ethnicity]);
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ethnicities');
	}

}
