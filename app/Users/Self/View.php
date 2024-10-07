<?php

namespace App\Users\Self;

use App\Permissions\Permissions;
use App\Traits\CheckPermissionStatus;
use App\Users\Helpers\GetSingleUserMetaData;
use App\Users\Helpers\ViewUserHelper;

class View extends Permissions
{
    use CheckPermissionStatus, GetSingleUserMetaData, ViewUserHelper;

    public function __construct($current_user)
    {
        $this->current_user = $current_user;

        $this->permission_collection = 'users';
    }

    public function view()
    {
        try
        {
            return $this->viewUser($this);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Your data cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}