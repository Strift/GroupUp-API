<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Game;
use App\Session;
use Carbon\Carbon;

class SessionsController extends Controller
{
    public function create(Request $request, User $user)
    {
    	try
    	{
    		$validator = Validator::make($request->only(['game', 'duration']), 
    			[
    				'game' => 'required|exists:games,name',
    				'duration' => 'required|numeric|min:1'
    			]);
            if ($validator->fails())
            {
                return response()->error($validator->messages(), 422);
            }
    		$session = Session::create([
    			'schedule_id' => $user->schedule->id,
    			'game_id' => Game::findByName($request->game),
    			'start_date' => Carbon::now(),
    			'duration' => $request->duration
    			]);
    		return response()->success($session->toArray());
    	}
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }
}
