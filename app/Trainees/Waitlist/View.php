<?php

namespace App\Trainees\Waitlist;

use Exception;
use App\Models\Trainee;
use App\Traits\GetList;
use App\Traits\GetUser;
use App\Traits\GetGeneralMeta;
use App\Permissions\Permissions;
use App\Traits\CheckPermissionStatus;
use App\Trainees\Helpers\GetTraineeMeta;
use App\Trainees\Helpers\ViewTraineesHelper;

class View extends Permissions
{
    use CheckPermissionStatus, GetTraineeMeta, ViewTraineesHelper, GetGeneralMeta, GetList, GetUser;

    public function __construct($current_user)
    {
        $this->current_user = $current_user;

        $this->permission_collection = 'waitlist';

        $this->list = "Wait List";

        $this->level_collection = "waitlist_level";

        $this->keys = ['id', 'full_name', 'notes', 'attend_type'];
    }

    public function view(?Trainee $trainee)
    {
        try 
        {
            return $this->viewTrainees($trainee, $this);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The trainees cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}