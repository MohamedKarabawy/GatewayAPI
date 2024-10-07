<?php

namespace App\Users\Deletes;

use App\Models\User;
use App\Http\Requests\BulkRequest;
use App\Traits\BulkHelper;
use Exception;

class BulkDelete
{
    use BulkHelper;

    public function __construct()
    {
        $this->permission = 'deleteUser';
    }

    public function delete(?User $user, BulkRequest $request)
    {
        $this->Authorized($user, $request->users, $this);

        try
        {
            foreach($request->users as $user_id)
            {
                $current_user = $user->find($user_id);
    
                $current_user->delete();
            }

            return response(['message' => "Users deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The users cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}