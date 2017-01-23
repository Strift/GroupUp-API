<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

use App\User;

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
            $validator = $this->validator($request->only([$this->username(), 'password']));
            if ($validator->fails()) {
                return response()->error($validator->messages(), 422);
            }

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                Log::warning("Too many login attempts from " . $request->ip() . ".");
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                Log::info("User " . Auth::user()->id . " logged in.");
                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            $this->username() => 'required',
            'password' => 'required',
        ]);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        return response()->success($this->guard()->user()->makeVisible(['email', 'api_token'])->toArray());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->error([$this->username() => Lang::get('auth.failed')], 422);
    } 

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return response()->error([$this->username() => $message], 429);
    }

    protected function username()
    {
        return $this->username;
    }
}
