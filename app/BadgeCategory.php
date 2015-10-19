<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BadgeCategory extends Model {

    public function section()
    {
        return $this->belongsTo('App\Section');
    }

    public function badges()
    {
        return $this->hasMany('App\Badge', 'category_id');
    }

    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();

        if (Auth::check() && !is_null(Auth::user()->filterSection)) {
            $query = $query->whereRaw('section_id = ? or section_id is null', [Auth::user()->filterSection->id]);
        }

        return $query;
    }

}
