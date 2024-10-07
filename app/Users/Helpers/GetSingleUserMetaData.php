<?php

namespace App\Users\Helpers;


trait GetSingleUserMetaData
{
    protected function getCollection($class)
    {
            $phone_index = 0;

            $roles_collection = [];

            $status_collection = [];

            $phone_collection = [];

            $meta_collection = [];

            $user_collection = ['branch' => $class->current_user->branch->district, 'full_name' => $class->current_user->full_name, 'email' => $class->current_user->email];

            foreach($class->current_user->user_meta as $meta)
            {
                str_contains($meta->meta_key, 'phone_number') ? $phone_collection['phone_numbers'][$phone_index++] = $meta->meta_value : $meta_collection[$meta->meta_key] = $meta->meta_value;
            }

            $class->isAllowed($class->current_user, 'view-self-role', $class->current_user?->user_id) && $roles_collection = ['role' => $class->current_user->role->role];

            $class->isAllowed($class->current_user, 'view-self-status', $class->current_user?->user_id) && $status_collection = ['status' => $class->current_user->is_activated];

            $collection = [...$user_collection, ...$roles_collection, ...$status_collection, ...$phone_collection, ...$meta_collection, 'created_at' => $class->current_user->created_at, 'updated_at' => $class->current_user->updated_at];

        return $collection;
    }
}