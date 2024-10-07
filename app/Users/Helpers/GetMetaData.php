<?php

namespace App\Users\Helpers;


trait GetMetaData
{
    protected function getCollection($users, $class)
    {
        $collection = ['empty'];

        foreach($users as $key => $user)
        {
            $roles_collection = [];

            $status_collection = [];

            $phone_collection = [];

            $meta_collection = [];

            $phone_index = 0;

            $user_collection = ['id' => $user->id, 'branch' => $user->branch->district, 'full_name' => $user->full_name, 'email' => $user->email];
    
            foreach($user->user_meta as $meta)
            {
                $meta_collection[$meta->meta_key] = $meta->meta_value;
            }

            $class->isAllowed($class->current_user, $class->permission_collection, 'view-roles', $user?->user_id) && $roles_collection = ['role' => $user->role->role];

            $class->isAllowed($class->current_user, $class->permission_collection, 'view-status', $user?->user_id) && $status_collection = ['status' => $user->is_activated];

            $class->isAllowed($class->current_user, $class->permission_collection, 'view-self-role', $user?->user_id) && $roles_collection = ['role' => $user->role->role];

            $class->isAllowed($class->current_user, $class->permission_collection, 'view-self-status', $user?->user_id) && $status_collection = ['status' => $user->is_activated];
            
            $collection[$key] = [...$user_collection, ...$roles_collection, ...$status_collection, ...$meta_collection, 'created_at' => $user->created_at, 'updated_at' => $user->updated_at];
        }
        

        return $collection;
    }
}