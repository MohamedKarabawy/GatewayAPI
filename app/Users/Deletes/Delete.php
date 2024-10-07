<?php

namespace App\Users\Deletes;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Exception;

class Delete
{
    public function __construct(?User $user, $id)
    {
        Gate::authorize('deleteUser', User::find($id));
    }

    public function delete(?User $user, $id)
    {
        try
        {
            $current_user = $user->find($id);
                
            $current_user->delete();

            return response(['message' => "User deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The user cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}