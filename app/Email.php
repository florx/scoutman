<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model {

    protected $fillable = [
        'email_from_id',
        'user_id',
        'subject',
        'content',
        'schedule',
        'attachments',
    ];

    protected $dates = ['schedule'];

    public function sender(){
        return $this->belongsTo('App\EmailFrom', 'email_from_id');
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
