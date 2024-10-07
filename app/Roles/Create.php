<?php

namespace App\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Permissions\Permissions;
use Exception;


class Create extends Permissions
{
    public function __construct(?Role $role)
    {
        Gate::authorize('createRole', $role);
    }

    public function create(?Role $role, ?Permission $permission, RoleRequest $request)
    {
        try
        {
            $created_role = $role->create(['role' => $request->role_title]);

            foreach($this->permission as $collection_key => $collection)
            {
                foreach($collection as $permission_key => $permission_value)
                {
                    $per_key = is_string($permission_key) ? $permission_key : $permission_value;

                    is_bool($request->permissions[$collection_key][$per_key]) && $permission->create(['role_id' => $created_role->id, 'per_collection' => $collection_key, 'per_key' => $per_key, 'per_value' => $request->permissions[$collection_key][$per_key]]);
                }
            }

            return response(['message' => "Role created successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The role cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}
