<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts (index route).
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view posts');
    }

    /**
     * Determine whether the user can create posts (create and store routes).
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create posts');
    }

    /**
     * Determine whether the user can update the post (edit and update routes).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        if ($user->can('update any posts')) {
            return true;
        }

        if ($user->can('update own posts')) {
            return (bool) $user->id == $post->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the post (delete route).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        if ($user->can('delete any posts')) {
            return true;
        }

        if ($user->can('delete own posts')) {
            return $user->id == $post->user_id;
        }

        return false;
    }
}
