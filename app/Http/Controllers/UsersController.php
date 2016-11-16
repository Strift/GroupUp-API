<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function list()
    {
	    try
        {
            $users = User::all();
            return $users->toJson();
        }
        catch (Exception $e)
        {
            return response()->json("{}", 500);
        }
    }
}
