<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

use App\User;

class FrontController extends Controller
{
    public function accountVerification(Request $request)
    {
    	try
    	{
    		$user = User::findByVerificationToken($request->token);
    		if ($user != null) 
    		{
	    		$user->verifyAccount();
                Log::info("User " . $user->id . " verified account.");
	    		return view('verification.success')->with(['username' => $user->username, 'email' => $user->email]);
    		}
            return response()->view('verification.failure', [], 422);
    	}
    	catch (Exception $e)
    	{
            return response()->view('errors.500', [], 500);
    	}
    }
}
