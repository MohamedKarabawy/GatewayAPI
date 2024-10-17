<?php

namespace App\Batches\Classes\Class\Add;


use Exception;
use App\Models\Classes;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AddAdminNote
{
    public function __construct(?Classes $class)
    {
        Gate::authorize('addAdminNote', $class);
    }

    public function addAdminNote(?Attendance $attendance, Request $request, $class_id, $trainee_id)
    {
        try
        {
            $is_exists = $attendance->where("class_id", $class_id)->where("trainee_id", $trainee_id)->exists();
            
            if($is_exists)
            {
                $attendance->where("class_id", $class_id)->where("trainee_id", $trainee_id)->update([
                    "admin_note" => $request->admin_note,
                ]);
                
                return response(['message' => "Admin note added successfully."], 200);
            }

            return response(['message' => "Cannot add admin note. This trainee is not exists in attendance."], 400);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Admin note cannot be added to trainee. Please contact the administrator of the website."], 400);
        }
    }
}