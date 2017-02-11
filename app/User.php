<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kodeine\Acl\Traits\HasRole;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'api_token', 'verification_token'
    ];

    /**
     * The attributes that should be visible for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id', 'username', 'status'
    ];

    public static function findByEmail($email)
    {
        return self::where('email', '=', $email)->first();
    }

    public static function findByUsername($username)
    {
        return self::where('username', '=', $username)->first();
    }

    public static function findByVerificationToken($token)
    {
        return self::where('verification_token', '=', $token)->first();
    }

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
        return $this->hasMany(Friend::class, 'owner_id');
    }

    /**
     * Add a friend to the user, return true in case of success
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function addFriend(User $user)
    {
        if (/*$this->id == $user->id or */$this->hasFriend($user) == false)
        {
            $friend = new Friend;
            $friend->owner()->associate($this);
            $friend->user()->associate($user);
            $this->friends()->save($friend);
            $this->load('friends');
            return true;
        }
        return false;
    }

    public function removeFriend(User $user)
    {
        // Pretty sure this could be improved by checking the return value of detach
        if ($this->hasFriend($user)) 
        {
            $this->friends()->where('user_id', $user->id)->delete();
            return true;
        }
        return false;
    }

    public function hasFriend(User $user)
    {
        $this->load('friends');
        return !$this->friends->filter(function($friend) use ($user) {
            return $friend->user->id == $user->id;
        })->isEmpty();
    }

    public function verifyAccount()
    {
        if ($this->verified_at == null) 
        {
            $this->verified_at = Carbon::now();
            $this->save();
            return true;
        }
        return false;
    }

    public function isVerifiedAccount()
    {
        return ($this->verified_at != null);
    }
}
