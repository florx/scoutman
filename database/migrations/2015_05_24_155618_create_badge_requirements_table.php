<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgeRequirementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('badge_requirements', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');

            $table->integer('badge_id')->unsigned()->index();
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');

            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->foreign('parent_id')->references('id')->on('badge_requirements')->onDelete('cascade');

            $table->integer('min_required');
            $table->tinyInteger('text_entry');
            $table->text('content');

			$table->timestamps();
		});

        Schema::create('badge_requirement_youth', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->integer('badge_requirement_id')->unsigned()->index();
            $table->foreign('badge_requirement_id')->references('id')->on('badge_requirements')->onDelete('cascade');

            $table->integer('youth_id')->unsigned()->index();
            $table->foreign('youth_id')->references('id')->on('youths')->onDelete('cascade');

            $table->string('value');

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

        $badgeList = \App\Badge::all();
        $badgeMap = [];
        foreach($badgeList as $badge){
            $badgeMap[$badge->category_id][$badge->name] = $badge->id;
        }

        $data = array_map('str_getcsv', file(storage_path() . '/app/badgeRequirements.csv'));
        $levelIDMap = [];

        foreach($data as $row) {
            if(count($row) < 6) continue;
            list($sectionName, $categoryName, $badgeName, $level, $min_required, $text_entry, $content) = $row;

            $level = intval($level);

            if($sectionName == 'Staged'){
                $badge_category_id = $stagedCategoryID;
            }else{
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
                    $badge_category_id = $categoryMap[$section_id][$categoryName];
                }

                if (!isset($badgeMap[$badge_category_id][$badgeName])) {
                    echo "Unknown Badge " . $badgeName . ".\n" . print_R($row, 1) . "\n";
                    continue;
                } else {
                    $badge_id = $badgeMap[$badge_category_id][$badgeName];
                }
            }

            if($level == 0){
                $parent_id = null;
                $levelIDMap = [];
            }else{
                $parent_id = $levelIDMap[$level-1];
            }

            $text_entry = ($text_entry == 'Y' ? 1 : 0);

            $req = \App\BadgeRequirement::forceCreate(compact('badge_id', 'parent_id', 'min_required', 'text_entry', 'content'));
            $levelIDMap[$level] = $req->id;


        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('badge_requirement_youth');
		Schema::drop('badge_requirements');
	}

}
