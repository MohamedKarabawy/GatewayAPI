<?php

namespace App\Batches\Classes\Class;

use App\Models\Classes;
use App\Models\TraineeClass;
use App\Traits\GetTraineeMeta;
use App\Traits\GetTraineeStatus;
use App\Batches\Helpers\GetClass;
use App\Traits\CheckPermissionStatus;
use App\Batches\Helpers\ViewClassHelper;


class View
{
    use CheckPermissionStatus, ViewClassHelper, GetTraineeMeta, GetTraineeStatus, GetClass;
    
    public function __construct($current_user)
    {
        $this->current_user = $current_user;

        $this->permission_collection = 'classes';
    }

    public function view(?Classes $class, ?TraineeClass $trainee, $batch_id, $class_id)
    {
        try
        {    
            return $this->viewClass($class, $trainee, $batch_id, $class_id, $this);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Classes cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}