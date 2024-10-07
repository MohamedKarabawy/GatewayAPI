<?php

namespace App\Users;

use App\Models\User;
use App\Models\UserMeta;
use App\Traits\CreateMeta;
use App\Traits\UpdateMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Traits\GetBranch;
use App\Traits\GetRole;
use App\Permissions\Permissions;
use App\Users\Helpers\UserDataHelper;
use App\Traits\PermissionUniqueness;
use App\Users\Helpers\UpdateUserAdditionalData;
use App\Users\Helpers\UpdateUserEssentialData;
use Exception;


class Update extends Permissions
{
    use GetRole, GetBranch, CreateMeta, UpdateMeta, UserDataHelper, UpdateUserEssentialData, UpdateUserAdditionalData, PermissionUniqueness;

    public function __construct(?User $user, $current_user, $id)
    {
        Gate::authorize('updateUser', User::find($id));

        $this->current_user = $current_user;

        $this->permissions = ['update-all', 'update-own'];

        $this->permission_collection = 'users';
    }

    public function update(?User $user, ?UserMeta $UserMeta, Request $request, $id)
    {
        try 
        {
            $this->UpdateUserEssentialData($user->find($id), $request, $this);

            $this->UpdateUserAdditionalData($UserMeta, $user->find($id)->id, $request, $this);

            return response(['message' => "Account updated successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The user cannot be updated. Please contact the administrator of the website."], 400);
        }
    }
}