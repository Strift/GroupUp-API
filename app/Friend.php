<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public function owner()
    {
    	return $this->belongsTo(User::class, 'owner_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
