<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
	protected $fillable = [
		'schedule_id', 'game_id', 'start_date', 'duration'
	];

    protected $visible = [
        'start_date', 'duration', 'activity'
    ];

    protected $appends = [
        'activity'
    ];

    public function game()
    {
    	return $this->belongsTo(Game::class);
    }

    public function setGame(Game $game)
    {
    	$this->game()->associate($game);
    }

    public function getActivityAttribute()
    {
        return $this->game->name;
    }
}
