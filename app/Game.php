<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
	public static function findByName($name)
    {
        return self::where('name', '=', $name)->first();
    }

    public function interestedUsers()
    {
    	return $this->belongsToMany(User::class);
    }
}
