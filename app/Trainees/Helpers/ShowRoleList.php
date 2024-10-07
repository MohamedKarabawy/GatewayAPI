<?php 

namespace App\Trainees\Helpers;

trait ShowRoleList
{
    protected function viewList($user, $permission, $class)
    {
        $users = $user->get();
    
        $collection = [];

        $index = 0;

        foreach ($users as $user)
        {
            boolval($permission->where('role_id', $user->role_id)->where('per_collection', $class->collection)->where('per_key', $class->permission)->first()?->per_value) &&
            
            $collection[$index++] = ['id' => $user->id, 'full_name' => $user->full_name, 'email' => $user->email];
        }

        $message = count($collection) > 0 ? response(['users' => $collection], 200) : response(['message' => 'Unauthorized'], 401);

        return $message;
    }
}