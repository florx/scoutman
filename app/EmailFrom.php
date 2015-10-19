<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailFrom extends Model {

    public function getDescriptorAttribute()
    {
        return $this->attributes['name'] . ' <' . $this->attributes['email'] . '>';
    }

}
