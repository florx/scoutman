<?php namespace App;


use Helpers\ScoutManBadgeResolver;
use Helpers\ScoutManTelephone;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Youth extends Model {

    use SoftDeletes;

    protected $fillable = [
        'section_id',
        'title',
        'first_name',
        'middle_names',
        'last_name',
        'dob',
        'address_line1',
        'address_line2',
        'address_line3',
        'address_line4',
        'postal_town',
        'postal_county',
        'postal_code',
        'telephone',
        'email',
        'patrol_name',
        'nationality_id',
        'faith_id',
        'ethnicity_id',
        'doctor_name',
        'surgery_id',
        'nhs_number',
        'dietary_needs',
        'medical_info',
        'swim',
        'bannedFirearms',
        'disability_notes'];

    protected $dates = ['dob', 'deleted_at'];

    /**
     * Return the full name of the Youth.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = Carbon::parse($date);
    }


    public function getTelephoneAttribute(){
        if(!isset($this->attributes['telephone'])) return '';
        return ScoutManTelephone::format($this->attributes['telephone']);
    }

    public function getValidMobileAttribute(){
        return ScoutManTelephone::isMobile($this->telephone);
    }

    public function parents()
    {
        return $this->belongsToMany('App\YouthParent');
    }

    public function emergency_contacts()
    {
        return $this->belongsToMany('App\YouthParent', 'youth_emergency_contact');
    }

    public function disabilities()
    {
        return $this->belongsToMany('App\Disability');
    }

    public function ethnicity()
    {
        return $this->belongsTo('\App\Ethnicity');
    }

    public function faith()
    {
        return $this->belongsTo('\App\Faith');
    }

    public function nationality()
    {
        return $this->belongsTo('\App\Nationality');
    }

    public function section()
    {
        return $this->belongsTo('\App\Section');
    }

    public function surgery()
    {
        return $this->belongsTo('\App\Surgery');
    }

    public function badgeRequirements(){
        return $this->belongsToMany('\App\BadgeRequirement')->withPivot(['value']);
    }

    public function badges(){
        return $this->belongsToMany('App\Badge')->withPivot(['status', 'plus', 'instructor'])->withTimestamps();
    }

    public function getBadgeStatus(Badge $badge){
        return $this->badges($badge->id)->first()->status;
    }

    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();

        if (empty($ordered)) {
            return $query;
        }

        if(Auth::check() && !is_null(Auth::user()->filterSection)){
            $query = $query->where('section_id', '=', Auth::user()->filterSection->id);
        }

        return $query->orderBy('section_id', 'ASC')->orderBy('first_name', 'ASC')->orderBy('last_name', 'ASC');
    }

    public function scopeSection($query, $sectionID){
        return $query->where('section_id', $sectionID);
    }

    protected $appends = array('almost_badges');

    public function getAlmostBadgesAttribute(){
        return ScoutManBadgeResolver::getInstance()->calculateYouthAlmostBadgeList($this->id);
    }

}