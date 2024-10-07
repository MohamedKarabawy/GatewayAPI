<?php

namespace App\Users\PendingUsers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Exception;

class Activate
{
    public function __construct(?User $user, $id)
    {
        Gate::authorize('activatePendingUser', $user->find($id));
    }

    public function activate(?User $user, $id)
    {
        try
        {
            $current_user = $user->find($id);
                
            $current_user->update([
                'is_activated' => true
            ]);

            return response(['message' => "User activated successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The user cannot be activated. Please contact the administrator of the website."], 400);
        }
    }
}