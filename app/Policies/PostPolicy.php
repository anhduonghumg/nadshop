<?php

namespace App\Policies;

use App\Models\M_user;
use App\Models\Post;
use App\Constants\Constants;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\HasPermissions;

class PostPolicy
{
    use HandlesAuthorization, HasPermissions;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\M_user  $mUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(M_user $user, Post $post)
    {
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\M_user  $mUser
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?M_user $user, Post $post)
    {
        return ($post->status == Constants::PUBLIC ||
            ($user && ($user->id == $post->user_id
                || $user->hasPermission('show')
            ))
        );
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\M_user  $mUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(M_user $user)
    {
        return $user->hasPermission('create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\M_user  $mUser
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(M_user $user, Post $post)
    {
        return ($user->hasPermission('edit'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\M_user  $mUser
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(M_user $user, Post $post)
    {
        return ($user->hasPermission('delete'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\M_user  $mUser
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(M_user $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\M_user  $mUser
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(M_user $user, Post $post)
    {
        //
    }
}
