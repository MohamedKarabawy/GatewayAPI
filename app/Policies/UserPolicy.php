<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\CheckPermission;

class UserPolicy
{
    use CheckPermission;

    public function __construct()
    {
        $this->permissions = ['create' => ['create-users'],
        'view' => ['view-users', 'view-own-users'],
        'update' => ['update-users', 'update-own-users'],
        'delete' => ['delete-users', 'delete-own-users'],
        'update-self' => ['update-self'],
        'delete-self' => ['delete-self'],
        'activate-pending' => ['assign-activate'], 
        'delete-pending' => ['delete-pending-users']];

        $this->permission_collection['users'] = 'users';

        $this->permission_collection['pendingusers'] = 'pendingusers';
    }

    public function activatePendingUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['activate-pending'], $this->permission_collection['pendingusers']) && !boolval($user->is_activated);
    }

    public function deletePendingUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete-pending'], $this->permission_collection['pendingusers']) && !boolval($user->is_activated);
    }
    
    public function viewUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection['users'], $user->user_id);
    }

    public function createUser(?User $user)
    {
        return $this->CheckPermission($user, $this->permissions['create'], $this->permission_collection['users']);
    }

    public function updateUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['update'], $this->permission_collection['users'], $user->user_id);
    }

    public function updateSelf(?User $current_user)
    {
        return $this->CheckPermission($current_user, $this->permissions['update-self'], $this->permission_collection['users']);
    }

    public function deleteUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection['users'], $user->user_id);
    }

    public function deleteSelf(?User $current_user)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete-self'], $this->permission_collection['users']);
    }
}