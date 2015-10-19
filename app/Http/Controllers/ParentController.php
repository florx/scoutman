<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ParentRequest;
use App\YouthParent;
use Flash;
use Illuminate\Http\Request;

class ParentController extends Controller {

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
        $parents = YouthParent::all();
        return view('parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('parents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ParentRequest $request
     * @return Response
     */
    public function store(ParentRequest $request)
    {
        $parent = YouthParent::create($request->all());

        Flash::success('That parent has been created!');
        return redirect('parents/' . $parent->id);
    }

    /**
     * Display the specified resource.
     *
     * @param YouthParent $parent
     * @return Response
     * @internal param Youth $youth
     */
    public function show(YouthParent $parent)
    {
        return view('parents.show', compact('parent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param YouthParent $parent
     * @return Response
     * @internal param Youth $youth
     */
    public function edit(YouthParent $parent)
    {
        return view('parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ParentRequest|Request $request
     * @param YouthParent $parent
     * @return Response
     * @internal param Youth $youth
     */
    public function update(ParentRequest $request, YouthParent $parent)
    {
        $parent->update($request->all());

        Flash::success('That parent has been updated!');
        return redirect('parents/' . $parent->id);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
