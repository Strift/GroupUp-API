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

    public function view(User $user)
    {
        try
        {
            return $user->toJson();
        }
        catch (Exception $e)
        {
            return response()->json("{}", 500);
        }
    }

    public function delete(User $user)
    {
        try
        {
            $user->delete();
            return response()->json("{}", 200);
        }
        catch (Exception $e)
        {
            return response()->json("{}", 500);
        }
    }
}
