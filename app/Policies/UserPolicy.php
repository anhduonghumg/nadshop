<?php

namespace App\Policies;

use App\Models\M_user;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\HasPermissions;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\M_user  $mUser
     * @return \Illuminate\Auth\Access\Response|bool
     */


    public function viewAny(M_user $mUser)
    {
    }


    public function view(M_user $user)
    {
    }


    public function create(M_user $mUser)
    {
    }


    public function update(M_user $mUser)
    {
        //
    }


    public function delete(M_user $mUser)
    {
        //
    }


    public function restore(M_user $mUser)
    {
        //
    }


    public function forceDelete(M_user $mUser)
    {
        //
    }
}
