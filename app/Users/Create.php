<?php

namespace App\Users;

use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Users\CreateUserRequest;
use App\Traits\GetBranch;
use App\Traits\GetRole;
use App\Permissions\Permissions;
use App\Traits\CreateMeta;
use App\Users\Helpers\UserDataHelper;
use App\Traits\PermissionUniqueness;
use App\Users\Helpers\StoreUserAddtionalData;
use App\Users\Helpers\StoreUserEssentialData;
use Exception;

class Create extends Permissions
{
    use GetRole, GetBranch, CreateMeta, UserDataHelper, StoreUserAddtionalData, StoreUserEssentialData, PermissionUniqueness;

    public function __construct(?User $user, $current_user)
    {
        Gate::authorize('createUser', $user);

        $this->current_user = $current_user;

        $this->permission_collection = 'users';
    }

    public function create(?User $user, ?UserMeta $UserMeta, CreateUserRequest $request)
    {
        try 
        {
            $created_user = $this->StoreUserEssentialData($user, $request, 'assign-user', $this);

            $this->StoreUserAddtionalData($UserMeta, $created_user->id, $request, $this);

            return response(['message' => "Account created successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The user cannot be registered. Please contact the administrator of the website."], 400);
        }
    }
}