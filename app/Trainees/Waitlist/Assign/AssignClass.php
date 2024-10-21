<?php

namespace App\Trainees\Waitlist\Assign;

use Exception;
use App\Models\Trainee;
use App\Models\TraineeClass;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AssignClass 
{
    public function __construct(?Trainee $trainee, $trainee_id)
    {
        Gate::authorize('assignClass', $trainee->find($trainee_id));
    }

    public function assign(?Trainee $trainee, ?TraineeClass $trainee_class, Request $request, $trainee_id)
    {
        try
        {
            $is_exists = $trainee_class->where('class_id', $request->class_id)->where('trainee_id', $trainee_id)->exists();
            
            if ($is_exists) 
            {
                return response(['message' => "Class is already assigned to this trainee."], 400);
            }

            $current_trainee = $trainee->find($trainee_id);

            $current_trainee->pervious_list = $current_trainee->current_list;

            $current_trainee->current_list = null;

            $current_trainee->save();
            
            $trainee_class->create([
                'class_id' => $request->class_id,
                'trainee_id' => $trainee_id,
                'confirmation' => false
            ]);

            Attendance::create([
                "class_id" => $request->class_id,
                "trainee_id" => $trainee_id, 
            ]);

            return response(['message' => "Class assigned successfully."], 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Cannot assign class. Please contact the administrator of the website."], 400);
        }
    }
}