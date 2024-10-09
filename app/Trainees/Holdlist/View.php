<?php

namespace App\Trainees\Holdlist;

use App\Models\Trainee;
use App\Permissions\Permissions;
use App\Traits\GetGeneralMeta;
use App\Traits\CheckPermissionStatus;
use App\Trainees\Helpers\GetHoldTraineesData;
use App\Trainees\Helpers\ViewTraineesHelper;
use App\Traits\GetList;
use Exception;

class View extends Permissions
{
    use CheckPermissionStatus, GetHoldTraineesData, ViewTraineesHelper, GetGeneralMeta, GetList;

    public function __construct($current_user)
    {
        $this->current_user = $current_user;

        $this->permission_collection = 'holdlist';

        $this->list = "Hold List";

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