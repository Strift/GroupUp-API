<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	protected $username;

	public function login(Request $request)
    {
    	try
    	{
    		// Define the username used for credentials
    		$this->username = $request->has('username') ? 'username' : 'email';

    		// Validation
    		$validator = $this->validator($request->only(['email', 'password']));
    		if ($validator->fails())
    		{
    			return response()->error($validator->messages(), 422);
    		}

    		// If the class is using the ThrottlesLogins trait, we can automatically throttle
	        // the login attempts for this application. We'll key this by the username and
	        // the IP address of the client making these requests into this application.
	        if ($this->hasTooManyLoginAttempts($request)) {
	            $this->fireLockoutEvent($request);
	            return $this->sendLockoutResponse($request);
	        }

	        if ($this->attemptLogin($request)) 
	        {
	        	$user = Auth::user();
	        	return response()->success($user->makeVisible('api_token')->toArray());
            	//return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
	        // to login and redirect the user back to the login form. Of course, when this
	        // user surpasses their maximum number of attempts they will get locked out.
	        $this->incrementLoginAttempts($request);

	        return response()->error([
	        						'input' => $request->only('email'),
	        						$this->username() => Lang::get('auth.failed')
	        						], 500);
	        //return $this->sendFailedLoginResponse($request);
    	}
    	catch (Exception $e)
    	{
    		return response()->error($e->getMessage(), 500);
    	}
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    } 

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);
    } 

    protected function username()
    {
    	return $this->username;
    }  

    protected function guard()
    {
        return Auth::guard();
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }
}
