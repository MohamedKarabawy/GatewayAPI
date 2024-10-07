<?php

namespace App\Users\PendingUsers;

use App\Models\User;
use App\Http\Requests\BulkRequest;
use App\Traits\BulkHelper;
use Exception;

class BulkActivate
{
    use BulkHelper;

    public function __construct()
    {
        $this->permission = 'activatePendingUser';
    }

    public function activate(?User $user, BulkRequest $request)
    {
        $this->Authorized($user, $request->users, $this);

        try
        {
            foreach($request->users as $user_id)
            {
                $current_user = $user->find($user_id);
                
                $current_user->update([
                    'is_activated' => true
                ]);
            }
          

            return response(['message' => "User activated successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The user cannot be activated. Please contact the administrator of the website."], 400);
        }
    }
}