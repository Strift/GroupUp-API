<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can list users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return $user->hasRole('administrator');
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $otherUser
     * @return mixed
     */
    public function view(User $user, User $otherUser)
    {
        return ($user->hasRole('administrator') or $user->id == $otherUser->id);
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $otherUser
     * @return mixed
     */
    public function update(User $user, User $otherUser)
    {
        //
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $otherUser
     * @return mixed
     */
    public function delete(User $user, User $otherUser)
    {
        return ($user->id == $otherUser->id);
    }

    /**
     * Determine whether the user can view the user's friends.
     *
     * @param  \App\User  $user
     * @param  \App\User  $otherUser
     * @return mixed
     */
    public function listFriends(User $user, User $otherUser)
    {
        return ($user->hasRole('administrator') or $user->id == $otherUser->id);
    }

    /**
     * Determine whether the user can add a user as friend.
     *
     * @param  \App\User  $user
     * @param  \App\User  $otherUser
     * @return mixed
     */
    public function addFriend(User $user, User $otherUser)
    {
        return ($user->hasRole('administrator') or $user->id == $otherUser->id);
    }

    /**
     * Determine whether the user can remove a friend.
     *
     * @param  \App\User  $user
     * @param  \App\User  $otherUser
     * @return mixed
     */
    public function removeFriend(User $user, User $otherUser)
    {
        return ($user->hasRole('administrator') or $user->id == $otherUser->id);
    }
}
