<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Classes;
use App\Models\ClassMeta;
use App\Traits\CheckPermission;
use Illuminate\Auth\Access\Response;

class ClassesPolicy
{
    use CheckPermission;
    
    public function __construct()
    {
        $this->permissions = ['create-classes' => ['create_classes'],
        'view-classes' => ['view_classes', 'view_own_classes'],
        'update-classes' => ['update_classes', 'update_own_classes'],
        'delete-classes' => ['delete_classes', 'delete_own_classes'],
        'add-update-view-components' => ['create_classes', 'update_classes', 'update_own_classes'],
        'move-to-black' => ['move_to_black'],
        'move-to-refund' => ['move_to_refund'],
        'move-to-wait' => ['move_to_wait'],
        'move-to-hold' => ['move_to_hold']
    ];

        $this->permission_collection = 'classes';
    }

    public function authComponents(?User $current_user,?Classes $class)
    {
        return $this->CheckPermission($current_user, $this->permissions['add-update-view-components'], $this->permission_collection);
    }

    public function createClasses(?User $current_user,?Classes $class)
    {
        return $this->CheckPermission($current_user, $this->permissions['create-classes'], $this->permission_collection);
    }

    public function viewClasses(?User $current_user,?Classes $class)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-classes'], $this->permission_collection, $class->user_id);
    }

    public function updateClasses(?User $current_user,?Classes $class)
    {
        return $this->CheckPermission($current_user, $this->permissions['update-classes'], $this->permission_collection, $class->user_id);
    }

    public function deleteClasses(?User $current_user,?Classes $class)
    {
        return $this->CheckPermission($current_user, $this->permissions['delete-classes'], $this->permission_collection, $class->user_id);
    }
}