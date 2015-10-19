<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 05/07/2015
 * Time: 11:58
 */

namespace app\Http\Controllers;


use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;


class MeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function filter(){
        return view('me.filter');
    }

    public function saveFilter(Request $request){
        Auth::user()->update($request->all());

        \Flash::success('The filter has been updated!');
        return redirect('/');
    }

    public function deleteFilter(){
        Auth::user()->filter_section_id = null;
        Auth::user()->save();

        \Flash::success('The filter has been removed!');
        return redirect('/');
    }

    public function getTfa(){
        return view('me.tfa_choice');
    }

    public function postTfa(){

        if(is_null(Auth::user()->tfa_token)) {

            Session::put('tfa', true);

            $google2fa = new Google2FA();
            Auth::user()->tfa_token = $google2fa->generateSecretKey();
            Auth::user()->save();

            $google2fa_url = $google2fa->getQRCodeGoogleUrl(
                'ScoutMan',
                Auth::user()->email,
                Auth::user()->tfa_token
            );

            return view('me.tfa_barcode', compact('google2fa_url'));

        }else{
            Auth::user()->tfa_token = null;
            Auth::user()->save();

            \Flash::success('Two factor authentication has been removed from your account.');
            return redirect('me/tfa');
        }

    }
}