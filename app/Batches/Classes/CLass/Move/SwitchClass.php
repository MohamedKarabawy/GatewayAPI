<?php

namespace App\Batches\Classes\Class\Move;


use Exception;
use App\Models\Classes;
use App\Models\TraineeClass;
use Illuminate\Support\Facades\Gate;

class SwitchClass
{
    public function __construct(?Classes $class)
    {
        Gate::authorize('switchClass', $class);
    }

    public function switchClass(?TraineeClass $trainee_class, Request $request, $class_id, $trainee_id)
    {
        try
        {
            $is_exists = $trainee_class->where("class_id", $class_id)->where("trainee_id", $trainee_id)->exists();
            
            if($is_exists){
                $trainee_class->where("class_id", $class_id)->where("trainee_id", $trainee_id)->update([
                    "class_id" => $request->class_id
                ]);
                
            return response(['message' => "Class switched successfully."], 200);
            }

            return response(['message' => "Cannot switch class. Class not exists."], 400);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Class cannot be switched. Please contact the administrator of the website."], 400);
        }
    }
}