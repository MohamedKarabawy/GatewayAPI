<?php

namespace App\Batches\Classes\Class\Add;


use Exception;
use App\Models\Attendance;


class AddToAttendance
{
    public function __construct()
    {
        
    }

    public function addToAttendance(?Attendance $attendance, $class_id, $trainee_id)
    {
        try
        {
            $is_exists = $attendance->where("class_id", $class_id)->where("trainee_id", $trainee_id)->exists();
            
            !$is_exists && $attendance->create([
                "class_id" => $class_id,
                "trainee_id" => $trainee_id, 
            ]);

            return response(['message' => "Trainee added to attendance successfully."], 201);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Trainee cannot be added to attendance. Please contact the administrator of the website."], 400);
        }
    }
}