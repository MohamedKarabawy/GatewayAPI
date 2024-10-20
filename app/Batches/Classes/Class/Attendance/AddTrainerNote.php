<?php

namespace App\Batches\Classes\Class\Attendance;


use Exception;
use App\Models\Classes;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AddTrainerNote
{
    public function __construct(?Classes $class)
    {
        Gate::authorize('addTrainerNote', $class);
    }

    public function addTrainerNote(?Attendance $attendance, Request $request, $class_id, $trainee_id)
    {
        try
        {
            $is_exists = $attendance->where("class_id", $class_id)->where("trainee_id", $trainee_id)->exists();
            
            if($is_exists)
            {
                $attendance->where("class_id", $class_id)->where("trainee_id", $trainee_id)->update([
                    "trainer_note" => $request->trainer_note,
                ]);
                
                return response(['message' => "Trainer note added successfully."], 200);
            }

            return response(['message' => "Cannot add trainer note. This trainee is not exists in attendance."], 400);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Trainer note cannot be added to trainee. Please contact the administrator of the website."], 400);
        }
    }
}