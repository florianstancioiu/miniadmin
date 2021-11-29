<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any pages (index route).
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view pages');
    }

    /**
     * Determine whether the user can create pages (create route).
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create pages');
    }

    /**
     * Determine whether the user can update the page (edit and update routes).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return bool
     */
    public function update(User $user, Page $page)
    {
        if ($user->can('update any pages')) {
            return true;
        }

        if ($user->can('update own pages')) {
            return (bool) $user->id == $page->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the page (delete route).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Page  $page
     * @return bool
     */
    public function delete(User $user, Page $page)
    {
        if ($user->can('delete any page')) {
            return true;
        }

        if ($user->can('delete own pages')) {
            return $user->id == $page->user_id;
        }

        return false;
    }
}
