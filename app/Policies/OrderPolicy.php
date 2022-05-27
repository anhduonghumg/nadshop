<?php

namespace App\Policies;

use App\Models\M_user;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Traits\HasPermissions;

class OrderPolicy
{
    use HandlesAuthorization, HasPermissions;

    public function viewAny(M_user $mUser)
    {
        //
    }

    public function view(M_user $user, Order $order)
    {
        return ($user->hasPermission('show'));
    }

    public function create(M_user $user)
    {
    }


    public function update(M_user $user, Order $order)
    {
        return ($user->hasPermission('edit-order'));
    }


    public function delete(M_user $user, Order $order)
    {
        return ($user->hasPermission('delete-order'));
    }

    public function restore(M_user $user, Order $order)
    {
        return ($user->hasPermission('restore-order'));
    }
}
