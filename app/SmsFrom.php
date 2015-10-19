<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsFrom extends Model {

    public function getDescriptorAttribute()
    {
        return $this->attributes['from'] . ' (' . $this->attributes['name'] . ')';
    }

}
