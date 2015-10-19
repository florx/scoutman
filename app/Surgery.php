<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Surgery extends Model {

    protected $fillable = [
        'address_line1',
        'address_line2',
        'address_line3',
        'address_line4',
        'postal_town',
        'postal_county',
        'postal_code',
        'telephone'];

}
