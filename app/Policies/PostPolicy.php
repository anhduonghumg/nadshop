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

    public function viewAny(M_user $user, Post $post)
    {
    }


    public function view(?M_user $user, Post $post)
    {
        return ($post->status == Constants::PUBLIC ||
            ($user && ($user->id == $post->user_id
                || $user->hasPermission('show')
            ))
        );
    }

    public function create(M_user $user)
    {
        return $user->hasPermission('create-post');
    }



    public function update(M_user $user, Post $post)
    {
        return $user->hasPermission('edit-post');
    }

    public function delete(M_user $user, Post $post)
    {
        return ($user->hasPermission('delete-post'));
    }


    public function restore(M_user $user, Post $post)
    {
    }


    public function forceDelete(M_user $user, Post $post)
    {
    }
}
