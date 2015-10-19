<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('badges', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');
            $table->string('name');
            $table->string('image');

            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('badge_categories')->onDelete('cascade');

			$table->timestamps();
		});

        Schema::create('badge_youth', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->integer('badge_id')->unsigned()->index();
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');

            $table->integer('youth_id')->unsigned()->index();
            $table->foreign('youth_id')->references('id')->on('youths')->onDelete('cascade');

            $table->date('achieved_at');
            $table->date('awarded_at');

            $table->timestamps();
        });

        $sectionList = \App\Section::all();
        $sectionMap = [];
        foreach($sectionList as $section){
            $sectionMap[$section->name] = $section->id;
        }

        $stagedCategoryID = 0;
        $categoryList = \App\BadgeCategory::all();
        $categoryMap = [];
        foreach($categoryList as $category){
            if(is_null($category->section_id)){
                $stagedCategoryID = $category->id;
            }else {
                $categoryMap[$category->section_id][$category->name] = $category->id;
            }
        }

        $data = array_map('str_getcsv', file(storage_path() . '/app/badges.csv'));

        foreach($data as $row){
            if(count($row) < 4) continue;
            list($sectionName, $categoryName, $name, $image) = $row;

            if($sectionName == 'Staged'){
                $category_id = $stagedCategoryID;
            }else {
                if (!isset($sectionMap[$sectionName])) {
                    echo "Unknown Section " . $sectionName . ".\n" . print_R($row, 1) . "\n";
                    continue;
                } else {
                    $section_id = $sectionMap[$sectionName];
                }

                if (!isset($categoryMap[$section_id][$categoryName])) {
                    echo "Unknown Category " . $categoryName . ".\n" . print_R($row, 1) . "\n";
                    continue;
                } else {
                    $category_id = $categoryMap[$section_id][$categoryName];
                }
            }

            \App\Badge::forceCreate(compact('category_id', 'name', 'image'));
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('badge_youth');
		Schema::drop('badges');
	}

}
