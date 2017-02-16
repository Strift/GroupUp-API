<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Game;

class GamesController extends Controller
{
    public function list()
    {
    	try
        {
        	$games = Game::all();
            return response()->success($games->toArray());
        }
        catch (Exception $e)
        {
            return response()->error($e->getMessage(), 500);
        }
    }
}
