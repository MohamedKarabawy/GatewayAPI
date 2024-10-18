<?php

namespace App\Batches\Classes\Class\Attendance;

use Exception;
use App\Models\Attendance;
use App\Models\SessionNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AddSessionNote
{
    public function __construct(Attendance $attendance)
    {
        Gate::authorize('addSessionNotes', $attendance);
    }

    public function addSessionNote(SessionNote $session_note, Attendance $attendance, Request $request, $class_id, $trainee_id)
    {
        try
        {
            $current_attendance = $attendance->where('class_id', $class_id)->where('trainee_id', $trainee_id)->first();

            if(!$current_attendance)
            {
                return response(['message' => 'Trainee not found in the given class.'], 400);
            }
            
            $session_note->create([
                'attend_id' => $current_attendance->id,
                'session_title' => $request->session_title,
                'session_status' => false
            ]);

            return response(['message' => 'Session note added successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Session note cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}