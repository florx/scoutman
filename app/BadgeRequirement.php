<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BadgeRequirement extends Model {

    public function requirements(){
        return $this->hasMany('App\BadgeRequirement', 'parent_id')->where('badge_id', '=', $this->badge_id);
    }

    public function youths()
    {
        return $this->belongsToMany('App\Youth');
    }

    public static function loadFromCSV($csvLocation){

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

        $stagedCategory = \App\BadgeCategory::whereRaw('name = ? and section_id is null', ['Staged badges'])->first();
        $occCategory = \App\BadgeCategory::whereRaw('name = ? and section_id is null', ['Occasional badges'])->first();


        $data = array_map('str_getcsv', file(storage_path() . $csvLocation));
        $levelIDMap = [];

        foreach($data as $row) {
            if(count($row) < 6) continue;
            list($sectionName, $categoryName, $badgeName, $level, $min_required, $text_entry, $content) = $row;

            $level = intval($level);

            if($categoryName == 'Staged') {
                $badge_category_id = $stagedCategory->id;
            }elseif($categoryName == 'Occasional'){
                $badge_category_id = $occCategory->id;
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
            }

            if (!isset($badgeMap[$badge_category_id][$badgeName])) {
                echo "Unknown Badge " . $badgeName . ".\n" . print_R($row, 1) . "\n";
                continue;
            } else {
                $badge_id = $badgeMap[$badge_category_id][$badgeName];
            }

            if($level == 0){
                $parent_id = null;
                $levelIDMap = [];
            }else{
                $parent_id = $levelIDMap[$level-1];
            }

            $text_entry = ($text_entry == '1' ? 1 : 0);

            //Debug
            //$content = $badgeName . ' ' . $content;

            $req = \App\BadgeRequirement::forceCreate(compact('badge_id', 'parent_id', 'min_required', 'text_entry', 'content'));
            $levelIDMap[$level] = $req->id;


        }
    }

}
