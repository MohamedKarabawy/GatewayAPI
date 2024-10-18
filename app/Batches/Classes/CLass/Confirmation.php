<?php

namespace App\Batches\Classes\Class;

use Exception;
use App\Models\Classes;
use App\Models\TraineeClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class Confirmation
{

    public function __construct(?Classes $class, $class_id)
    {
        Gate::authorize('updateClasses', $class->find($class_id));
    }

    public function confirm(?TraineeClass $trainee_class, Request $request, $class_id, $trainee_id)
    {
        try
        {            
            $current_trainee = $trainee_class->where('class_id', $class_id)->where('trainee_id', $trainee_id)->first();

            if(!$current_trainee)
            {
                return response(['message' => "Class is not found for this trainee."], 400);
            }

            $request->filled('confirmation') && $current_trainee->confirmation = boolval($current_trainee->confirmation);

            $request->all() >= 1 && $current_trainee->save();
            
            return response(['message' => "Class updated successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Class cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}