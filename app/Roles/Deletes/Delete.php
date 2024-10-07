<?php

namespace App\Roles\Deletes;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Exception;

class Delete
{
    public function __construct(?Role $role)
    {
        Gate::authorize('deleteRole', $role);
    }

    public function delete(?Role $role, $id)
    {
        try
        {
            $current_role = $role->find($id);

            $current_role->delete();

            return response(['message' => "Role deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Role cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}