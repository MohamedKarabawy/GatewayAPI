<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\CheckPermission;

class UserPolicy
{
    use CheckPermission;

    public function __construct()
    {
        $this->permissions = ['create' => ['create_users'],
        'view' => ['view_users', 'view_own_users'],
        'update' => ['update_users', 'update_own_users'],
        'delete' => ['delete_users', 'delete_own_users'],
        'update-self' => ['update_self'],
        'delete-self' => ['delete_self'],
        'activate-pending' => ['assign_activate'], 
        'delete-pending' => ['delete_pending_users']];

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

    public function updateSelf(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['update-self'], $this->permission_collection['users']);
    }

    public function deleteUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection['users'], $user->user_id);
    }

    public function deleteSelf(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete-self'], $this->permission_collection['users']);
    }
}