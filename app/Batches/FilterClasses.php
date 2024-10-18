<?php

namespace App\Batches;

use Exception;
use App\Models\Batch;
use App\Models\Classes;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ViewClasses
{
    public function __construct($current_class)
    {
        $this->current_user = $current_user;
        
        $this->permission_collection = 'classes';
    }

    public function viewClasses(?Classes $class, ?Batch $batch, Request $request, $batch_id)
    {
        try
        {
            
            return response($classes_collection, 200);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Classes cannot be viewed. Please contact the administrator of the website."], 400);
        }   
    }
}