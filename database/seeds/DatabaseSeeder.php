<?php

use App\EmailFrom;
use App\SmsFrom;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Section;
use App\Nationality;
use App\Ethnicity;
use App\Faith;
use App\Youth;
use App\YouthParent;
use App\Disability;


class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('UserTableSeeder');

        SmsFrom::forceCreate(['name' => 'Jake Mobile', 'from' => '07506127076']);
        SmsFrom::forceCreate(['name' => '49th Newcastle', 'from' => '49TH NEWCASTLE']);

        EmailFrom::forceCreate(['name' => 'Cubs', 'email' => 'cubs@49thnewcastle.org.uk']);
        EmailFrom::forceCreate(['name' => 'Danny', 'email' => 'danny@49thnewcastle.org.uk']);

        $faker = Faker\Factory::create('en_GB');

        for($i=0;$i<50;$i++) {

            $sharedLastName = $faker->lastName;

            $parent1 = YouthParent::forceCreate([
                "title" => $faker->titleMale,
                "first_name" => $faker->firstNameMale,
                "last_name" => $sharedLastName,
                "dob" => "1962-05-21",
                "gender" => 'M',
                "relationship" => "Father",
                "email" => $faker->email,
                //"telephone" => $faker->mobileNumber,
                "address_line1" => $faker->streetName,
                "address_line2" => $faker->streetAddress,
                "address_line3" => null,
                "address_line4" => null,
                "postal_town" => $faker->city,
                "postal_county" => $faker->county,
                "postal_code" => $faker->postcode]);

            $parent2 = YouthParent::forceCreate([
                "title" => $faker->titleFemale,
                "first_name" => $faker->firstNameFemale,
                "last_name" => $sharedLastName,
                "dob" => "1963-02-13",
                "gender" => "F",
                "relationship" => "Mother",
                "email" => $faker->email,
                //"telephone" => $faker->mobileNumber(),
                "address_line1" => $faker->streetName,
                "address_line2" => $faker->streetAddress,
                "address_line3" => null,
                "address_line4" => null,
                "postal_town" => $faker->city,
                "postal_county" => $faker->county,
                "postal_code" => $faker->postcode]);

            $emergencyContact = YouthParent::forceCreate([
                "title" => $faker->titleMale,
                "first_name" => $faker->firstNameMale,
                "last_name" => $sharedLastName,
                "dob" => "1962-05-21",
                "gender" => $faker->randomElement(['M', 'F']),
                "relationship" => "Emergency Contact",
                "email" => $faker->email,
                //"telephone" => $faker->mobileNumber,
                "address_line1" => $faker->streetName,
                "address_line2" => $faker->streetAddress,
                "address_line3" => null,
                "address_line4" => null,
                "postal_town" => $faker->city,
                "postal_county" => $faker->county,
                "postal_code" => $faker->postcode]);

            $surgery = \App\Surgery::forceCreate([
                "address_line1" => $faker->streetName,
                "address_line2" => $faker->streetAddress,
                "address_line3" => null,
                "address_line4" => null,
                "postal_town" => $faker->city,
                "postal_county" => $faker->county,
                "postal_code" => $faker->postcode,
                "telephone" => $faker->phoneNumber,
            ]);

            $youth = Youth::forceCreate([
                "section_id" => $faker->numberBetween(1,4),
                "title" => $faker->randomElement(['Master.', 'Miss.']),
                "first_name" => $faker->firstName,
                "middle_names" => $faker->firstName,
                "last_name" => $sharedLastName,
                "dob" => "1995-06-24",
                "address_line1" => $faker->streetAddress,
                "address_line2" => $faker->streetName,
                "address_line3" => null,
                "address_line4" => null,
                "postal_town" => $faker->city,
                "postal_county" => $faker->county,
                "postal_code" => $faker->postcode,
                "telephone" => $faker->phoneNumber,
                "email" => $faker->email,
                "patrol_name" => $faker->randomElement(['Red', 'Green', 'Yellow', 'Blue', 'Orange']),
                "nationality_id" => $faker->numberBetween(1, 5),
                "faith_id" => $faker->numberBetween(1, 5),
                "ethnicity_id" => $faker->numberBetween(1, 5),
                "doctor_name" => 'Dr. ' . $faker->lastName,
                "surgery_id" => $surgery->id,
                "nhs_number" => $faker->randomNumber(5),
                "dietary_needs" => null,
                "medical_info" => null
            ]);

            $youth->parents()->attach($parent1->id);
            $youth->parents()->attach($parent2->id);
            $youth->emergency_contacts()->attach($parent1->id);
            $youth->emergency_contacts()->attach($emergencyContact->id);

        }

	}

}
