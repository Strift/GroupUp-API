<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return response()->error($validator->messages(), 422);
            }
            $user = $this->create($request->all());
            event(new UserRegistered($user));
            return response()->success($user->makeVisible('email')->toArray());
        } catch (Exception $e) {
            return response()->error($e->getMessage(), 500);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token' => str_random(60)
        ]);
    }
}
