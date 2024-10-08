<?php

namespace App\Users\Helpers;


trait ViewUsersHelper
{ 
    protected function viewUsers($users, $class)
    {
        $users_data = [];

        foreach($class->permission_keys as $permission_key)
        {
            $class->CheckPermissionStatus($class->current_user, $class->permission_collection, $permission_key) && $users_data =  $class->getCollection($users->where('is_activated', $class->status)->get(), $class);
    
            (str_contains($permission_key, 'view_own') && $class->CheckPermissionStatus($class->current_user, $class->permission_collection, $permission_key) && count($users_data) === 0) && 
    
            $users_data = $class->getCollection($users->where('user_id', $class->current_user->id)->where('is_activated', $class->status)->get(), $class);
        }

        $message = count($users_data) === 0 ? response(['message' => 'Unauthorized'], 401) : response(['users' => $users_data], 201);

        (count($users_data) > 0 && $users_data[0] === 'empty') && $message = response(['message' => 'List is empty.'], 201);

        return $message;
    }
}