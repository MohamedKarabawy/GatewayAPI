<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Traits\CheckPermission;

class RolePolicy
{
    use CheckPermission;

    public function __construct()
    {
        $this->permissions = ['create' => ['create-role'],
        'view' => ['view-roles'],
        'view-permissions' => ['view-permissions'],
        'update' => ['update-role'],
        'delete' => ['delete-role']];

        $this->permission_collection = 'roles';
    }

    public function viewPermissions(?User $current_user, ?Role $role)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-permissions'], $this->permission_collection);
    }

    public function viewRole(?User $current_user, ?Role $role)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection);
    }

    public function createRole(?User $current_user, ?Role $role)
    {
        return $this->CheckPermission($current_user, $this->permissions['create'], $this->permission_collection);
    }

    public function updateRole(?User $current_user, ?Role $role)
    {
        return $this->CheckPermission($current_user, $this->permissions['update'], $this->permission_collection);
    }

    public function deleteRole(?User $current_user, ?Role $role)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection);
    }
}