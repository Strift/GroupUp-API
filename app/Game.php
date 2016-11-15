<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function interestedUsers()
    {
    	return $this->belongsToMany(User::class);
    }
}
