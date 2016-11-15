<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function game()
    {
    	return $this->belongsTo(Game::class);
    }

    public function setGame(Game $game)
    {
    	$this->game()->associate($game);
    }
}
