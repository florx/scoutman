<?php namespace App;

use Carbon\Carbon;
use Helpers\ScoutManTelephone;
use Illuminate\Database\Eloquent\Model;

class YouthParent extends Model {

    protected $dates = ['dob'];

    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'dob',
        'relationship',
        'address_line1',
        'address_line2',
        'address_line3',
        'address_line4',
        'postal_town',
        'postal_county',
        'postal_code',
        'telephone',
        'email',
        'gender',
        'occupation'
    ];

    /**
     * Return the full name of the Youth.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Get all the youths that are either the 'children'
     * or this parent is the emergency contact for them
     *
     * @return mixed
     */
    public function getAllAssociatedYouthsAttribute(){
        $children = $this->children;
        $youths = $this->youths;

        return $children->merge($youths)->unique();
    }

    public function getTelephoneAttribute(){
        if(!isset($this->attributes['telephone'])) return '';
        return ScoutManTelephone::format($this->attributes['telephone']);
    }



    /**
     * Get the youths that are the 'children' of this parent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany('App\Youth');
    }

    /**
     * Get the youths that this parent is the emergency contact for
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function youths()
    {
        return $this->belongsToMany('App\Youth', 'youth_emergency_contact');
    }

    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();

        if (empty($ordered)) {
            return $query;
        }

        return $query->orderBy('last_name', 'ASC')->orderBy('first_name', 'ASC');
    }

}
