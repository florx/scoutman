<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Youth;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function verifyDetails(){
        $youths = Youth::with('parents', 'emergency_contacts', 'disabilities',
            'ethnicity', 'faith', 'nationality', 'section', 'surgery')->get();
        return view('reports.verifyDetails', compact('youths'));
    }

}
