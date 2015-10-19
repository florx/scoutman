<?php namespace App\Http\Controllers;

use App\Badge;
use App\BadgeCategory;
use App\Http\Requests;
use App\Youth;
use Carbon\Carbon;
use Helpers\ScoutManBadgeResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class BadgeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List all of the badges
     *
     * @return \Illuminate\View\View
     */
    public function index()
	{
		$categoryList = BadgeCategory::all();
        return view('badge.index', compact('categoryList'));
	}

    /**
     * Allow leaders to assign youths to badge requirements
     *
     * @param Badge $badge
     * @return \Illuminate\View\View
     */
    public function show(Badge $badge){
        if(is_null($badge->category->section)){
            $youthList = Youth::all();
        }else{
            $youthList = $badge->category->section->youths;
        }

        return view('badge.show', compact('badge', 'youthList'));
    }

    /**
     * Store badge requirements gained by youths
     *
     * @param Badge $badge
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Badge $badge, Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'youth' => 'required',
                'req'   => 'required'
            ]
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $youthList = $badge->category->section->youths;
        $selectedYouthIDs = array_keys($request->get('youth'));
        $requirementsList = $badge->allRequirements;
        $requirementValues = $request->get('req');
        $selectedRequirementIDs = array_keys($requirementValues);

        foreach($youthList as $youth){
            if(!in_array($youth->id, $selectedYouthIDs)) continue;

            foreach($requirementsList as $requirement){
                if(!in_array($requirement->id, $selectedRequirementIDs)) continue;

                $reqVal = $requirementValues[$requirement->id];

                if(!empty($reqVal)){
                    if(!$requirement->youths->contains($youth->id)) {
                        $requirement->youths()->attach($youth->id, ['value' => $reqVal]);
                    }
                }

            }
        }

        ScoutManBadgeResolver::getInstance()->massChangedRequirements($badge);

        \Flash::success('The requirements have been marked as complete.');
        return redirect('badges');
    }

    public function indexYouthBadges(Youth $youth){
        $categoryList = $youth->section->badgeCategories;

        $badgeStatusMap = [];
        foreach($youth->badges as $badge){
            $badgeStatusMap[$badge->id] = $badge->pivot;
        }

        return view('badge.youth.index', compact('categoryList', 'youth', 'badgeStatusMap'));
    }

    public function showYouthBadges(Youth $youth, Badge $badge){

        $reqList = $youth->badgeRequirements()->where('badge_id', $badge->id)->get();

        $modelData = [];
        $modelData['req'] = [];

        foreach($reqList as $req){
            $modelData['req'][$req->id] = $req->pivot->value;
        }

        $statusRow = $badge->youths()->find($youth->id);
        $upgrade = 'none';
        $currentStatus = 'Incomplete';

        if(!is_null($statusRow)){
            $currentStatus = $statusRow->pivot->status;
            $statusTime = Carbon::parse($statusRow->pivot->updated_at)->format('jS F Y');

            if($statusRow->pivot->instructor == 1){
                $upgrade = 'instructor';
            } else if($statusRow->pivot->plus == 1){
                $upgrade = 'plus';
            }
        }

        return view('badge.youth.show', compact('badge', 'youth', 'modelData', 'currentStatus', 'statusTime', 'upgrade'));
    }

    public function storeYouthBadges(Youth $youth, Badge $badge, Request $request){

        $existingReqList = $youth->badgeRequirements()->where('badge_id', $badge->id)->get();

        $reqList = $request->get('req');

        foreach($existingReqList as $existingReq){
            if(!array_key_exists($existingReq->id, $reqList)){
                //means it has been deleted
                $youth->badgeRequirements()->detach($existingReq->id);
                unset($reqList[$existingReq->id]);
            }
        }

        foreach($reqList as $reqID => $val){
            if(!empty($val)) {
                $youth->badgeRequirements()->attach($reqID, ['value' => $val]);
            }else{
                $youth->badgeRequirements()->detach($reqID);
            }
        }

        $newStatus = $request->get('status');

        if(!is_null($newStatus) && $newStatus == 'Remove'){
            $badge->youths()->detach($youth->id);
            $newStatus = null;
        }

        if(!is_null($newStatus)){

            $upgrade = $request->get('upgrade');

            $plus = 0;
            $instructor = 0;

            if($upgrade == 'plus') {
                $plus = 1;
            }else if($upgrade == 'instructor'){
                $instructor = 1;
            }

            $badge->youths()->updateExistingPivot($youth->id, ['status' => $newStatus,
                                                                'plus' => $plus,
                                                                'instructor' => $instructor]);
        }else{
            ScoutManBadgeResolver::getInstance()->changedYouthRequirements($youth, $badge);
        }



        \Flash::success('Requirement achievements updated');
        return redirect('youths/'.$youth->id.'/badges/'.$badge->id);
    }

    public function showYouthBadgesMassAssign(Youth $youth){
        return view('badge.youth.massAssign', compact('youth'));
    }

    public function saveYouthBadgesMassAssign(Youth $youth, Request $request){

        $badgeList = $request->get('badges');

        foreach($badgeList as $badgeID) {

            if (!$youth->badges->contains($badgeID)) {
                $youth->badges()->attach($badgeID, ['status' => 'Sewn']);
            }else{
                $youth->badges()->updateExistingPivot($badgeID, ['status' => 'Sewn']);
            }
        }

        \Flash::success('Badges assigned to youth');
        return redirect('youths/'.$youth->id.'/badges');

    }

    public function youthReport(){
        $youths = Youth::all();
        $lastRunTime = ScoutManBadgeResolver::getInstance()->lastRunTime();
        return view('badge.youth.report', compact('youths', 'lastRunTime'));
    }

    public function youthReportRerun(Request $request){
        ScoutManBadgeResolver::getInstance()->run();

        if ($request->ajax()){
            return;
        }

        return redirect()->back();
    }
}
