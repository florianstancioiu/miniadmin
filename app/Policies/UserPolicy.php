<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users (index route).
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view users');
    }

    /**
     * Determine whether the user can create users (create and store routes).
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create users');
    }

    /**
     * Determine whether the user can update the user (edit and update routes).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $affected_user
     * @return bool
     */
    public function update(User $user, User $affected_user)
    {
        if ($user->can('update any users')) {
            return true;
        }

        if ($user->can('update own users')) {
            return (bool) $user->id == $affected_user->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can update password.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $affected_user
     * @return bool
     */
    public function updatePassword(User $user, User $affected_user)
    {
        if ($user->can('update any users')) {
            return true;
        }

        if ($user->can('update own users')) {
            return (bool) $user->id == $affected_user->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the user (delete route).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $affected_user
     * @return bool
     */
    public function delete(User $user, User $affected_user)
    {
        if ($user->can('delete any users')) {
            return true;
        }

        if ($user->can('delete own users')) {
            return $user->id == $affected_user->user_id;
        }

        return false;
    }
}
