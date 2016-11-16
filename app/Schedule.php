<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function sessions()
    {
    	return $this->hasMany(Session::class);
    }
}
