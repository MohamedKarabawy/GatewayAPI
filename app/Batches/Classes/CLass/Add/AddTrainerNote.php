<?php

namespace App\Batches\Classes\Class\Add;


use Exception;
use App\Models\Attendance;
use Illuminate\Http\Request;


class AddTrainerNote
{
    public function __construct()
    {
        
    }

    public function addTrainerNote(?Attendance $attendance, Request $request, $class_id, $trainee_id)
    {
        try
        {
            $is_exists = $attendance->where("class_id", $class_id)->where("trainee_id", $trainee_id)->exists();
            
            if($is_exists){
                $attendance->where("class_id", $class_id)->where("trainee_id", $trainee_id)->update([
                    "trainer_note" => $request->trainer_note,
                ]);
                
            return response(['message' => "Admin note added successfully."], 200);
            }

            return response(['message' => "Cannot add admin note. This trainee is not exists in attendance."], 400);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Trainee cannot be added to attendance. Please contact the administrator of the website."], 400);
        }
    }
}