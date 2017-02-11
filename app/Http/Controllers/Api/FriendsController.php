<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\User;

class FriendsController extends Controller
{
    public function view(User $user)
    {
        try
        {
        	$user = User::with('friends')->find($user->id);
            return response()->success($user->friends->toArray());
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function add(Request $request, User $user)
    {
        try
        {
            $validator = Validator::make($request->only(['username']), ['username' => 'required']);
            if ($validator->fails())
            {
                return response()->error($validator->messages(), 422);
            }
            $friend = User::findByUsername($request->username);
            $user->addFriend($friend);
            return response()->success($friend);
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function remove(Request $request, User $user)
    {
        try
        {
            $validator = Validator::make($request->only(['id']), ['id' => 'required']);
            if ($validator->fails())
            {
                return response()->error($validator->messages(), 422);
            }
            $friend = User::find($request->id);
            $user->removeFriend($friend);
            return response()->success($friend);
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }
}
