<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\YouthParent;
use Illuminate\Http\Request;
use App\Youth;
use App\Http\Requests\YouthRequest;

class YouthController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$youths = Youth::all();
        return view('youths.index', compact('youths'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('youths.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(YouthRequest $request)
	{
        $youth = Youth::create($request->all());

        $this->updateRelationships($request, $youth);

        \Flash::success('That youth has been created!');
        return redirect('youths/' . $youth->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Youth  $youth
	 * @return Response
	 */
	public function show(Youth $youth)
    {
		return view('youths.show', compact('youth'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Youth $youth
	 * @return Response
	 */
	public function edit(Youth $youth)
	{
		return view('youths.edit', compact('youth'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  Youth    $youth
	 * @return Response
	 */
	public function update(YouthRequest $request, Youth $youth)
	{
		$youth->update($request->all());

        $this->updateRelationships($request, $youth);

        \Flash::success('That youth has been updated!');
        return redirect('youths/' . $youth->id);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param Youth $youth
     * @return Response
     */
	public function destroy(Youth $youth)
	{
        $youth->delete();

        \Flash::success('That youth has been deleted!');
        return redirect('youths');
	}

    /**
     * @param YouthRequest $request
     * @param Youth $youth
     */
    private function updateRelationships(YouthRequest $request, Youth $youth){

        $parentsList = $request->get('parents');
        $ecList = $request->get('emergency_contacts');
        $disabilityList = $request->get('disabilities');

        if(!is_null($parentsList)) {
            $parentIDs = $this->findOrCreateParents($parentsList, 'Parent');
            $youth->parents()->sync($parentIDs);
        }else{
            $youth->parents()->detach();
        }

        if(!is_null($ecList)) {
            $ecIDs = $this->findOrCreateParents($ecList, 'Emergency Contact');
            $youth->emergency_contacts()->sync($ecIDs);
        }else{
            $youth->emergency_contacts()->detach();
        }

        if(!is_null($disabilityList)) {
            $youth->disabilities()->sync($disabilityList);
        }else{
            $youth->disabilities()->detach();
        }

    }

    var $previouslyCreatedParents = [];

    /**
     * Allow users to input a parent that doesn't yet exist.
     * It will create a new parent object for them.
     *
     * @param $parentsList
     * @param $relationship
     * @return mixed
     */
    private function findOrCreateParents($parentsList, $relationship){
        $parentIDs = [];

        foreach($parentsList as $parentIDorName){
            if(is_numeric($parentIDorName)){
                $parentIDs[] = $parentIDorName;

            }else{

                //Check whether we've already just created this parent for a different field.
                if(isset($this->previouslyCreatedParents[$parentIDorName])){
                    $parentObj = $this->previouslyCreatedParents[$parentIDorName];
                }else {
                    list($first_name, $last_name) = explode(' ', $parentIDorName, 2);
                    $parentObj = YouthParent::create(['first_name' => ucfirst($first_name),
                        'last_name' => ucfirst($last_name),
                        'relationship' => $relationship]);
                    $this->previouslyCreatedParents[$parentIDorName] = $parentObj;
                }


                $parentIDs[] = $parentObj->id;
            }
        }

        return $parentIDs;
    }

}
