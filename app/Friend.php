<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
        'owner_id', 'user_id', 'favorite'
    ];
    protected $visible = [
        'username', 'status', 'favorite'
    ];

    protected $appends = [
        'username', 'status'
    ];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'owner_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function getUsernameAttribute()
    {
    	return $this->user->username;
    }

    public function getStatusAttribute()
    {
    	return $this->user->status;
    }
}
