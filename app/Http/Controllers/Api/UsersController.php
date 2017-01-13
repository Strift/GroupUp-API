<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function list()
    {
	    try
        {
            $users = User::all();
            return response()->success($users->toArray());
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function view(User $user)
    {
        try
        {
            return response()->success($user->toArray());
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function delete(User $user)
    {
        try
        {
            $user->delete();
            return response()->success("User successfully deleted.");
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }
}
