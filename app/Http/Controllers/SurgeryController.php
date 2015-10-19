<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\surgeryRequest;
use App\Surgery;
use Flash;
use Illuminate\Http\Request;

class SurgeryController extends Controller {

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
        $surgeries = Surgery::all();
        return view('surgeries.index', compact('surgeries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('surgeries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param surgeryRequest $request
     * @return Response
     */
    public function store(SurgeryRequest $request)
    {
        $surgery = Surgery::create($request->all());

        Flash::success('That surgery has been created!');
        return redirect('surgeries/' . $surgery->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Surgery $surgery
     * @return Response
     * @internal param Youth $youth
     */
    public function show(Surgery $surgery)
    {
        return view('surgeries.show', compact('surgery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Surgery $surgery
     * @return Response
     * @internal param Youth $youth
     */
    public function edit(Surgery $surgery)
    {
        return view('surgeries.edit', compact('surgery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param surgeryRequest|Request $request
     * @param Surgery $surgery
     * @return Response
     * @internal param Youth $youth
     */
    public function update(SurgeryRequest $request, Surgery $surgery)
    {
        $surgery->update($request->all());

        Flash::success('That surgery has been updated!');
        return redirect('surgeries/' . $surgery->id);
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
