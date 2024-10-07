<?php

namespace App\Traits;

trait CheckPermissionStatus
{
    protected function CheckPermissionStatus($user, $permission_collection, $permission_key)
    {
        return $user->role->permissions->where('role_id', $user->role_id)->where('per_collection', $permission_collection)->where('per_key', $permission_key)->first()?->per_value;
    }
}