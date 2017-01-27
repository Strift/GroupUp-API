<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class FriendsController extends Controller
{
    public function view(User $user)
    {
        try {
            $user = User::with('friends')->find($user->id);
            return response()->success($user->friends->toArray());
        } catch (Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }
}
