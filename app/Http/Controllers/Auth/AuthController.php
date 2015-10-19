<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => ['getLogout', 'getTfa', 'postTfa']]);
	}

    public function getRegister(){
        App::abort(404);
    }

    public function postRegister(){
        App::abort(404);
    }

    public function getTfa(){
        return view('auth.tfa');
    }

    public function postTfa(Request $request){
        $response = $request->get('response');

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey(Auth::user()->tfa_token, $response);

        if($valid){
            Session::put('tfa', true);
            return redirect()->intended($this->redirectPath());
        }

        return redirect('auth/tfa')
            ->withErrors([
                'response' => 'The provided token was incorrect.'
            ]);
    }

}
