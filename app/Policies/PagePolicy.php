<?php

namespace App\Policies;

use App\Models\M_user;
use App\Models\Page\Page;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\HasPermissions;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\M_user  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(M_user $user)
    {
        //
    }


    public function view(M_user $user, Page $page)
    {
        //
    }


    public function create(M_user $user)
    {
        return $user->hasPermission('create-page');
    }


    public function update(M_user $user, Page $page)
    {
        return $user->hasPermission('update-page');
    }

    public function delete(M_user $user, Page $page)
    {
        return $user->hasPermission('delete-page');
    }

    public function restore(M_user $user, Page $page)
    {
        return $user->hasPermission('restore-page');
    }
}
