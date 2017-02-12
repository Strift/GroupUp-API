<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Friend;

use Log;

class FriendsController extends Controller
{
    public function list(User $owner)
    {
        try
        {
        	$friends = Friend::where('owner_id', $owner->id)->get();
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
            $friend = Friend::create([
                    'owner_id' => $owner->id,
                    'user_id' => User::findByUsername($request->username)->id,
                    'favorite' => false
                ]);
            return response()->success($friend->toArray());
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
            Friend::where('owner_id', $owner->id)
                ->where('user_id', User::findByUsername($request->username)->id)
                ->delete();
            return response()->success("Friend successfully deleted.");
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }

    public function favorite(Request $request, User $owner)
    {
        try
        {
            $validator = Validator::make($request->only(['username', 'favorite']), 
                [
                    'username' => 'required|exists:users,username',
                    'favorite' => 'required|boolean'
                ]);
            if ($validator->fails())
            {
                return response()->error($validator->messages(), 422);
            }
            $friend = Friend::where('owner_id', $owner->id)
                ->where('user_id', User::findByUsername($request->username)->id)
                ->first();
            $friend->favorite = (boolean) $request->favorite;
            $friend->save();
            return response()->success($friend->toArray());
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }
}
