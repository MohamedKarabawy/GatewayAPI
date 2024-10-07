<?php

namespace App\Roles;

use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use Exception;

class Update extends Permissions
{
    public function __construct(?Role $role)
    {
        Gate::authorize('updateRole', $role);
    }

    public function update(?Role $role, ?Permission $permission, RoleRequest $request, $id)
    {
        try
        {
            $intended_role = $role->find($id);

            foreach($this->permission as $collection_key => $collection)
            {
                foreach($collection as $permission_key => $permission_value)
                {
                    $per_key = is_string($permission_key) ? $permission_key : $permission_value;

                    is_bool($request->permissions[$collection_key][$per_key]) && $permission->where('role_id', $intended_role->id)->where('per_collection', $collection_key)->where('per_key', $per_key)->update(['per_value' => boolval($request->permissions[$collection_key][$per_key])]);
                }
            }

            return response(['message' => "Role updated successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The role cannot be updated. Please contact the administrator of the website."], 400);
        }
    }
}
