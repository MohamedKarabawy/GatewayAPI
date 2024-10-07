<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\CheckPermission;

class PendingUserPolicy
{
    use CheckPermission;
    
    public function __construct()
    {
        $this->permissions = ['activate' => ['assign-activate'], 'delete' => ['delete-pending-users']];

        $this->permission_collection = 'pendingusers';
    }

    public function activatePendingUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['activate'], $this->permission_collection) && !boolval($user->is_activated);
    }

    public function deletePendingUser(?User $current_user, ?User $user)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete'], $this->permission_collection) && !boolval($user->is_activated);
    }
}
