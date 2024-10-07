<?php

namespace App\Permissions;
use App\Models\User;

class Permissions
{
    protected $permission = [
        'general' => [
            'show-follow_up-list',
            'show-trainers-list'
        ],
        'branches' => [
            'create-branch',
            'view-branches',
            'update-branch',
            'delete-branch'
        ],
        'roles' => [
            'create-role',
            'view-roles',
            'view-permissions',
            'update-role',
            'delete-role'
        ],
        'users' => [
            'create-users',
            'assign-user-role' => 'role_id',
            'assign-user-status' => 'is_activated',
            'view-users',
            'view-roles' => 'role_id',
            'view-status' => 'is_activated',
            'view-own-users',
            'view-self',
            'view-self-role' => 'role_id',
            'view-self-status' => 'is_activated',
            'update-users',
            'update-all-roles' => 'role_id',
            'update-all-status' => 'is_activated',
            'update-own-users',
            'update-own-role' => 'role_id',
            'update-own-status' => 'is_activated',
            'update-self',
            'update-self-role' => 'role_id',
            'update-self-status' => 'is_activated',
            'delete-users',
            'delete-own-users',
            'delete-self'
        ],
        'pendingusers' => [
            'assign-activate' => 'is_activated',
            'view-pending-users',
            'delete-pending-users'
        ],
        "waitlist" => [
            'create-trainees',
            'assign-class' => 'class_id',
            'assign-trainer' => 'trainer_id',
            'assign-level' => 'level',
            'view-trainees',
            'view-trainers' => 'trainer_id',
            'view-levels' => 'level',
            'view-own-trainees',
            'view-own-trainers' => 'trainer_id',
            'view-own-levels' => 'level',
            'update-trainees',
            'update-all-trainers' => 'trainer_id',
            'update-all-levels' => 'level',
            'update-own-trainees',
            'update-own-trainers' => 'trainer_id',
            'update-own-levels' => 'level',
            'delete-trainees',
            'delete-own-trainees',
        ],
        "pendinglist" => [
            'create-trainees',
            'assign-follow_up' => 'follow_up',
            'assign-trainer' => 'trainer_id',
            'assign-level' => 'level',
            'view-trainees',
            'view-follow_up' => 'follow_up',
            'view-trainers' => 'trainer_id',
            'view-levels' => 'level',
            'view-own-trainees',
            'view-own-follow_up' => 'follow_up',
            'view-own-trainers' => 'trainer_id',
            'view-own-levels' => 'level',
            'update-trainees',
            'update-all-trainers' => 'trainer_id',
            'update-all-levels' => 'level',
            'update-own-trainees',
            'update-own-trainers' => 'trainer_id',
            'update-own-levels' => 'level',
            'delete-trainees',
            'delete-own-trainees',
        ],
        "holdlist" => [
            'assign-trainer' => 'trainer_id',
            'assign-level' => 'level',
            'view-trainees',
            'view-trainers' => 'trainer_id',
            'view-levels' => 'level',
            'view-own-trainees',
            'view-own-trainers' => 'trainer_id',
            'view-own-levels' => 'level',
            'update-trainees',
            'update-all-trainers' => 'trainer_id',
            'update-all-levels' => 'level',
            'update-own-trainees',
            'update-own-trainers' => 'trainer_id',
            'update-own-levels' => 'level',
            'delete-trainees',
            'delete-own-trainees',
        ],
        "refundlist" => [
            'assign-trainer' => 'trainer_id',
            'assign-level' => 'level',
            'view-trainees',
            'view-trainers' => 'trainer_id',
            'view-levels' => 'level',
            'view-own-trainees',
            'view-own-trainers' => 'trainer_id',
            'view-own-levels' => 'level',
            'update-trainees',
            'update-all-trainers' => 'trainer_id',
            'update-all-levels' => 'level',
            'update-own-trainees',
            'update-own-trainers' => 'trainer_id',
            'update-own-levels' => 'level',
            'delete-trainees',
            'delete-own-trainees',
        ],
        "blacklist" => [
            'assign-trainer' => 'trainer_id',
            'assign-level' => 'level',
            'view-trainees',
            'view-trainers' => 'trainer_id',
            'view-levels' => 'level',
            'view-own-trainees',
            'view-own-trainers' => 'trainer_id',
            'view-own-levels' => 'level',
            'update-trainees',
            'update-all-trainers' => 'trainer_id',
            'update-all-levels' => 'level',
            'update-own-trainees',
            'update-own-trainers' => 'trainer_id',
            'update-own-levels' => 'level',
            'delete-trainees',
            'delete-own-trainees',
        ],
    ];

    protected function isAllowed($user, $permission_key, $permission_collection, $user_id = null)
    {
        $allowed = false;

        foreach($user->role->permissions as $key => $permission)
        {
            if($permission->per_collection === $permission_collection && boolval($permission->per_value))
            {

                ($permission->per_key === $permission_key && $user->role_id === $permission->role_id) && (str_contains($permission->per_key, 'own')? $user->id === $user_id && $allowed = boolval($permission->per_value) : $allowed = boolval($permission->per_value));
            }
        }

        return $allowed;
    }
}