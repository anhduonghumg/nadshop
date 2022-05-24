<?php

namespace App\Traits;

use App\Models\Role;

trait HasPermissions
{
    protected $permissionList = null;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('role_name', $role);
        }

        return false;
    }

    public function hasPermission($permission = null)
    {
        if (is_null($permission)) {
            return $this->getPermissions()->count() > 0;
        }

        if (is_string($permission)) {
            return $this->getPermissions()->contains('per_name', $permission);
        }

        return false;
    }

    private function getPermissions()
    {
        $role = $this->roles->first();
        if ($role) {
            if (!$role->relationLoaded('permissions')) {
                $this->roles->load('permissions');
            }

            $this->permissionList = $this->roles->pluck('permissions')->flatten();
        }

        return $this->permissionList ?? collect();
    }
}
