<?php

namespace App\Permissions;
use App\Models\User;

class Permissions
{
    public $permission = [
        'general' => [
            'show_follow_up_list',
            'show_trainers_list'
        ],
        'branches' => [
            'create_branch',
            'view_branches',
            'update_branch',
            'delete_branch'
        ],
        'roles' => [
            'create_role',
            'view_roles',
            'view_permissions',
            'update_role',
            'delete_role'
        ],
        'users' => [
            'create_users',
            'assign_user_role' => 'role_id',
            'assign_user_status' => 'is_activated',
            'view_users',
            'view_roles' => 'role_id',
            'view_status' => 'is_activated',
            'view_own_users',
            'view_self',
            'view_self_role' => 'role_id',
            'view_self_status' => 'is_activated',
            'update_users',
            'update_all_roles' => 'role_id',
            'update_all_status' => 'is_activated',
            'update_own_users',
            'update_own_role' => 'role_id',
            'update_own_status' => 'is_activated',
            'update_self',
            'update_self_role' => 'role_id',
            'update_self_status' => 'is_activated',
            'delete_users',
            'delete_own_users',
            'delete_self'
        ],
        'pendingusers' => [
            'assign_activate' => 'is_activated',
            'view_pending_users',
            'delete_pending_users'
        ],
        "trainees" => [
            'view_trainees',  
        ],
        "waitlist" => [
            'move_to_hold',
            'move_to_blacklist',
            'move_to_refund',
            'create_trainees',
            'assign_class' => 'class_id',
            'assign_trainer' => 'trainer_id',
            'assign_level' => 'level',
            'view_trainees',
            'view_trainers' => 'trainer_id',
            'view_levels' => 'level',
            'view_own_trainees',
            'view_own_trainers' => 'trainer_id',
            'view_own_levels' => 'level',
            'update_trainees',
            'update_all_trainers' => 'trainer_id',
            'update_all_levels' => 'level',
            'update_own_trainees',
            'update_own_trainers' => 'trainer_id',
            'update_own_levels' => 'level',
            'delete_trainees',
            'delete_own_trainees',
        ],
        "pendinglist" => [
            'create_trainees',
            'assign_follow_up' => 'follow_up',
            'assign_trainer' => 'trainer_id',
            'assign_level' => 'level',
            'view_trainees',
            'view_follow_up' => 'follow_up',
            'view_trainers' => 'trainer_id',
            'view_levels' => 'level',
            'view_own_trainees',
            'view_own_follow_up' => 'follow_up',
            'view_own_trainers' => 'trainer_id',
            'view_own_levels' => 'level',
            'update_trainees',
            'update_all_trainers' => 'trainer_id',
            'update_all_levels' => 'level',
            'update_own_trainees',
            'update_own_trainers' => 'trainer_id',
            'update_own_levels' => 'level',
            'delete_trainees',
            'delete_own_trainees',
        ],
        "holdlist" => [
            'move_to_wait',
            'assign_trainer' => 'trainer_id',
            'assign_level' => 'level',
            'view_trainees',
            'view_trainers' => 'trainer_id',
            'view_levels' => 'level',
            'view_own_trainees',
            'view_own_trainers' => 'trainer_id',
            'view_own_levels' => 'level',
            'update_trainees',
            'update_all_trainers' => 'trainer_id',
            'update_all_levels' => 'level',
            'update_own_trainees',
            'update_own_trainers' => 'trainer_id',
            'update_own_levels' => 'level',
            'delete_trainees',
            'delete_own_trainees',
        ],
        "refundlist" => [
            'move_to_wait',
            'assign_trainer' => 'trainer_id',
            'assign_level' => 'level',
            'view_trainees',
            'view_trainers' => 'trainer_id',
            'view_levels' => 'level',
            'view_own_trainees',
            'view_own_trainers' => 'trainer_id',
            'view_own_levels' => 'level',
            'update_trainees',
            'update_all_trainers' => 'trainer_id',
            'update_all_levels' => 'level',
            'update_own_trainees',
            'update_own_trainers' => 'trainer_id',
            'update_own_levels' => 'level',
            'delete_trainees',
            'delete_own_trainees',
        ],
        "blacklist" => [
            'move_to_wait',
            'assign_trainer' => 'trainer_id',
            'assign_level' => 'level',
            'view_trainees',
            'view_trainers' => 'trainer_id',
            'view_levels' => 'level',
            'view_own_trainees',
            'view_own_trainers' => 'trainer_id',
            'view_own_levels' => 'level',
            'update_trainees',
            'update_all_trainers' => 'trainer_id',
            'update_all_levels' => 'level',
            'update_own_trainees',
            'update_own_trainers' => 'trainer_id',
            'update_own_levels' => 'level',
            'delete_trainees',
            'delete_own_trainees',
        ],
        "batches" => [
            'activate_batches',
            'activate_own_batches',
            'end_batches',
            'end_own_batches',
            'create_batches',
            'view_batches',
            'view_own_batches',
            'update_batches',
            'update_own_batches',
            'delete_batches',
            'delete_own_batches'
        ],
        "classes" => [
            "add_trainer_note",
            "add_admin_note",
            "add_to_attendance",
            "switch_class",
            "move_to_wait",
            "move_to_hold",
            "move_to_refund",
            "move_to_blacklist",
            'create_classes',
            'view_classes',
            'view_own_classes',
            'update_classes',
            'update_own_classes',
            'delete_classes',
            'delete_own_classes'
        ],
        "attendance" => [
            "view_attendance",
            "add_session_notes",
            "view_session_notes"
        ]
    ];

    protected function isAllowed($user, $permission_key, $permission_collection, $user_id = null)
    {
        $allowed = false;

        foreach((object) $user?->role->permissions as $key => $permission)
        {
            if($permission->per_collection === $permission_collection && boolval($permission->per_value))
            {
                ($permission->per_key === $permission_key && $user->role_id === $permission->role_id) && (str_contains($permission->per_key, 'own') || str_contains($permission->per_key, 'self')? $user->id === $user_id && $allowed = boolval($permission->per_value) : $allowed = boolval($permission->per_value));
            }
        }

        return $allowed;
    }
}