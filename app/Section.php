<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model {

	public function youths(){
        return $this->hasMany('App\Youth');
    }

    public function badgeCategories(){
        return $this->hasMany('App\BadgeCategory')->orWhere('section_id', null);
    }

}
