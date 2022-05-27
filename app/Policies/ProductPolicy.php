<?php

namespace App\Policies;

use App\Models\M_user;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(M_user $user)
    {
    }


    public function view(M_user $user, Product $product)
    {
        return $user->hasPermission('show');
    }


    public function create(M_user $user)
    {
        return $user->hasPermission('create-product');
    }


    public function update(M_user $user, Product $product)
    {
        return $user->hasPermission('edit-product');
    }


    public function delete(M_user $user, Product $product)
    {
        return $user->hasPermission('delete-product');
    }


    public function restore(M_user $user, Product $product)
    {
        return $user->hasPermission('restore-product');
    }

    public function forceDelete(M_user $user, Product $product)
    {
        //
    }
}
