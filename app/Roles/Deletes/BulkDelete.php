<?php

namespace App\Roles\Deletes;

use App\Models\Role;
use App\Http\Requests\BulkRoleRequest;
use App\Traits\BulkHelper;
use Exception;

class BulkDelete
{
    use BulkHelper;

    public function __construct()
    {
        $this->permission = 'deleteRole';
    }

    public function delete(?Role $role, BulkRoleRequest $request)
    {
        $this->Authorized($role, $request->roles, $this);

        try
        {
            foreach($request->roles as $role_id)
            {
                $current_role = $role->find($role_id);

                $current_role->delete();
            }

            return response(['message' => "Roles deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The roles cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}