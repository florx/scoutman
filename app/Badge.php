<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model {

    public function category()
    {
        return $this->belongsTo('App\BadgeCategory');
    }

    public function requirements(){
        return $this->hasMany('App\BadgeRequirement')->where('parent_id', null);
    }

    public function allRequirements(){
        return $this->hasMany('App\BadgeRequirement');
    }

    public function youths(){
        return $this->belongsToMany('App\Youth')->withPivot(['status', 'plus', 'instructor'])->withTimestamps();
    }

    public function youthsComplete(){
        return $this->belongsToMany('App\Youth')->where('status', '=', 'Complete');
    }

    public static function loadFromCSV($csvLocation){

        $sectionList = \App\Section::all();
        $sectionMap = [];
        foreach($sectionList as $section){
            $sectionMap[$section->name] = $section->id;
        }

        $categoryList = \App\BadgeCategory::all();
        $categoryMap = [];
        foreach($categoryList as $category){
            if(is_null($category->section_id)){
                $stagedCategoryID = $category->id;
            }else {
                $categoryMap[$category->section_id][$category->name] = $category->id;
            }
        }

        $stagedCategory = \App\BadgeCategory::whereRaw('name = ? and section_id is null', ['Staged badges'])->first();
        $occCategory = \App\BadgeCategory::whereRaw('name = ? and section_id is null', ['Occasional badges'])->first();

        $data = array_map('str_getcsv', file(storage_path() . $csvLocation));

        //print_r($data);

        foreach($data as $row){
            if(count($row) < 4) continue;
            list($sectionName, $categoryName, $name, $image) = $row;

            if($categoryName == 'Staged') {
                $category_id = $stagedCategory->id;
            }elseif($categoryName == 'Occasional'){
                $category_id = $occCategory->id;
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

}
