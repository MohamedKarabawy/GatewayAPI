<?php

namespace App\Users\Self;

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

    public function __construct($current_user)
    {
        Gate::authorize('updateSelf', $current_user);

        $this->current_user = $current_user;

        $this->permissions = ['update_self'];

        $this->permission_collection = 'users';
    }

    public function update(?UserMeta $UserMeta, Request $request)
    {
        try 
        {
            $this->UpdateUserEssentialData($this->current_user, $request, $this);

            $this->UpdateUserAdditionalData($UserMeta, $this->current_user->id, $request, $this);

            return response(['message' => "Account updated successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The user cannot be updated. Please contact the administrator of the website."], 400);
        }
    }
}