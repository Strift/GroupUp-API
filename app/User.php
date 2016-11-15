<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function interests()
    {
        return $this->belongsToMany(Game::class);
    }

    public function addInterest(Game $game)
    {
        $this->interests()->attach($game->id);
    }

    public function removeInterest(Game $game)
    {
        $this->interests()->detach($game->id);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function setSchedule(Schedule $schedule)
    {
        $this->schedule()->save($schedule);
    }
}
