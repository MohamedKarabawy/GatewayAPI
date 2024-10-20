<?php

namespace App\Batches\View;

use Exception;
use App\Models\Batch;
use App\Models\Classes;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Traits\CheckPermissionStatus;
use App\Batches\Helpers\GetFilteredClasses;
use App\Batches\Helpers\ViewFilteredClassesHelper;

class FilterClasses
{
    use ViewFilteredClassesHelper, GetFilteredClasses, CheckPermissionStatus;
    
    public function __construct($current_user)
    {
        $this->current_user = $current_user;
        
        $this->permission_collection = 'classes';
    }

    public function getClasses(?Classes $class, ?Batch $batch, Request $request, $batch_id)
    {
        try
        {
            return $this->viewClasses($class, $batch, $request, $batch_id, $this);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Classes cannot be viewed. Please contact the administrator of the website."], 400);
        }   
    }
}