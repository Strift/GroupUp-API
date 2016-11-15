<?php

namespace App\Observers;

use App\User;
use App\Schedule;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        $schedule = new Schedule;
        $schedule->user_id = $user->id;
        $schedule->save();
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        $user->schedule->delete();
    }
}