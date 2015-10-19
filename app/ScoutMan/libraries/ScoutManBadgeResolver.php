<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 30/05/2015
 * Time: 13:42
 */

namespace Helpers;


use App\Badge;
use App\Youth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ScoutManBadgeResolver {

    private $store = null, $youthList, $badgeList, $youth, $badge, $topLevelRequirement;
    private $almostThresholdSubReq = 0.5;
    private $almostThresholdReq = 0.5;
    const NOTACHIEVED = 0;
    const ALMOST = 1;
    const ACHIEVED = 2;

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    protected function __construct(){

        $this->youthList = Youth::with('badgeRequirements')->get();
        $this->badgeList = Badge::with('requirements', 'allRequirements')->get();

    }

    private function __clone(){}
    private function __wakeup(){}

    public function run(){

        foreach($this->youthList as $youth){
            $this->youth = $youth;
            $this->store[$this->youth->id] = [];
            $this->processYouth();
        }

        $this->save();

    }

    private function processYouth(){

        foreach($this->badgeList as $badge){
            $this->badge = $badge;
            $this->store[$this->youth->id][$this->badge->id] = [];
            $this->store[$this->youth->id][$this->badge->id]['requirements'] = [];
            $this->store[$this->youth->id][$this->badge->id]['status'] = [];
            $this->processBadge();
        }

    }


    /**
     * This is called from the individual youth/badge page where you can see
     * the current status of the badge for that youth.
     *
     *
     * @param Youth $youth
     * @param Badge $badge
     */
    public function changedYouthRequirements(Youth $youth, Badge $badge){
        $this->youth = $youth;
        $this->store[$this->youth->id] = [];
        $this->badge = $badge;
        $this->store[$this->youth->id][$this->badge->id] = [];
        $this->store[$this->youth->id][$this->badge->id]['requirements'] = [];
        $this->store[$this->youth->id][$this->badge->id]['status'] = [];
        $this->processBadge();

    }

    /**
     * This is called from the mass assignment page, where you can assign
     * requirements to more than one youth at once.
     *
     * @param Badge $badge
     */
    public function massChangedRequirements(Badge $badge){
        foreach($this->youthList as $youth) {
            $this->changedYouthRequirements($youth, $badge);
        }
    }

    private function processBadge(){

        $countAchieved = 0;
        $countAlmost = 0;

        foreach($this->badge->requirements as $requirement){
            $this->topLevelRequirement = $requirement;
            $res = $this->processTopLevelRequirement();
            $this->store[$this->youth->id][$this->badge->id]['requirements'][$this->topLevelRequirement->id] = $res;

            switch($res){
                case ScoutManBadgeResolver::ALMOST:
                    $countAlmost++;
                    break;
                case ScoutManBadgeResolver::ACHIEVED:
                    $countAchieved++;
                    break;
            }

        }

        if($countAchieved == count($this->badge->requirements)){

            if(!$this->badge->youths->contains($this->youth->id))
                $this->badge->youths()->attach($this->youth->id, ['status' => 'Complete']);

            $this->store[$this->youth->id][$this->badge->id]['status'] = ScoutManBadgeResolver::ACHIEVED;
        }elseif(($countAchieved + $countAlmost / count($this->badge->requirements)) >= $this->almostThresholdReq){
            $this->store[$this->youth->id][$this->badge->id]['status'] = ScoutManBadgeResolver::ALMOST;
        }else{
            $this->store[$this->youth->id][$this->badge->id]['status'] = ScoutManBadgeResolver::NOTACHIEVED;
        }

    }

    private function processTopLevelRequirement(){

        $countAchieved = 0;

        foreach($this->topLevelRequirement->requirements as $subRequirement){
            $res = $this->youth->badgeRequirements()->where('badge_requirement_id', $subRequirement->id)->count();

            if($res >= 1)
            {
                //sub req achieved!
                $countAchieved++;
            }
        }

        if($countAchieved >= $this->topLevelRequirement->min_required){
            //requirement achieved!
            return ScoutManBadgeResolver::ACHIEVED;
        }elseif(($countAchieved / $this->topLevelRequirement->min_required) >= $this->almostThresholdSubReq){
            return ScoutManBadgeResolver::ALMOST;
        }

        return ScoutManBadgeResolver::NOTACHIEVED;


    }

    private function save(){
        Storage::disk('local')->put('badgeStatus.json', json_encode($this->store));
    }

    public function retrive(){

        if (!Storage::disk('local')->exists('badgeStatus.json')){
            $this->run();
        }

        $json = Storage::disk('local')->get('badgeStatus.json');
        return json_decode($json, true);
    }

    public function lastRunTime(){
        $timestamp = Storage::disk('local')->lastModified('badgeStatus.json');
        return Carbon::createFromTimestamp($timestamp);
    }

    public function calculateYouthAlmostBadgeList($youthID){

        if(is_null($this->store))
            $this->store = $this->retrive();

        $almostBadge = [];

        foreach($this->badgeList as $badge){

            if(!isset($this->store[$youthID])) continue;
            if(!isset($this->store[$youthID][$badge->id])) continue;

            switch($this->store[$youthID][$badge->id]['status']){
                case ScoutManBadgeResolver::ALMOST:
                    $almostBadge[] = $badge;
                    break;
            }

        }

        return $almostBadge;
    }
}