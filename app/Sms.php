<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model {

    protected $fillable = [
        'sms_from_id',
        'user_id',
        'content',
        'schedule',
    ];

    protected $dates = ['schedule'];

    public function sender(){
        return $this->belongsTo('App\SmsFrom', 'sms_from_id');
    }

    public function youths()
    {
        return $this->belongsToMany('App\Youth')->withPivot('status')->withTimestamps();
    }

    public function parents()
    {
        return $this->belongsToMany('App\YouthParent')->withPivot('status')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('status')->withTimestamps();
    }

}
