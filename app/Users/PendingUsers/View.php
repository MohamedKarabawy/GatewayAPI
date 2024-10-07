<?php

namespace App\Users\PendingUsers;

use App\Models\User;
use App\Permissions\Permissions;
use App\Traits\CheckPermissionStatus;
use App\Users\Helpers\GetMetaData;
use App\Users\Helpers\ViewUsersHelper;
use Exception;

class View extends Permissions
{
    use CheckPermissionStatus, GetMetaData, ViewUsersHelper;

    public function __construct($current_user)
    {
        $this->current_user = $current_user;

        $this->permission_collection = 'pendingusers';

        $this->status = false;

        $this->permission_keys = ['view-pending-users'];
    }

    public function view(?User $user)
    {
        try
        {
            return $this->viewUsers($user, $this);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The users cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}