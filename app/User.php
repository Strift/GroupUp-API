<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kodeine\Acl\Traits\HasRole;

class User extends Authenticatable
{
    use Notifiable, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be visible for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id', 'username', 'status'
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

    public function sessions()
    {
        return $this->hasManyThrough(Session::class, Schedule::class);
    }

    public function friends()
    {
        return $this->belongsTomany('App\User', 'friends', 'user1_id', 'user2_id');
    }

    public function addFriend(User $user)
    {
        if ($this->hasFriend($user) == false) {
            $this->friends()->attach($user->id);
            $user->friends()->attach($this->id);
        }
    }

    public function removeFriend(User $user)
    {
        $this->friends()->detach($user->id);
        $user->friends()->detach($this->id);
    }

    public function hasFriend(User $user)
    {
        $this->load('friends');
        return !$this->friends->filter(function ($friend) use ($user) {
            return $friend->id = $user->id;
        })->isEmpty();
    }

    public static function findByEmail($email)
    {
        return self::where('email', '=', $email)->first();
    }
}
