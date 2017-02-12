<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Friend;

class FriendsController extends Controller
{
    public function list(User $owner)
    {
        try
        {
        	$friends = Friend::where('owner_id')->get();
            return response()->success($friends->toArray());
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function add(Request $request, User $owner)
    {
        try
        {
            $validator = Validator::make($request->only(['username']), ['username' => 'required|exists:users,username']);
            if ($validator->fails())
            {
                return response()->error($validator->messages(), 422);
            }
            $friend = User::findByUsername($request->username);
            $owner->addFriend($friend);
            return response()->success($friend);
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function remove(Request $request, User $owner)
    {
        try
        {
            $validator = Validator::make($request->only(['username']), ['username' => 'required|exists:users,username']);
            if ($validator->fails())
            {
                return response()->error($validator->messages(), 422);
            }
            $friend = User::findByUsername($request->username);
            $owner->removeFriend($friend);
            return response()->success($friend);
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }
}
