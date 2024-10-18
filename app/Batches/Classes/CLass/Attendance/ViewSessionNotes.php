<?php

namespace App\Batches\Classes\Class\Attendance;

use Exception;
use App\Models\Attendance;
use App\Models\SessionNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ViewSessionNote
{
    public function __construct(Attendance $attendance)
    {
        Gate::authorize('viewSessionNotes', $attendance);
    }

    public function viewSessionNote(SessionNote $session_note, Attendance $attendance, $class_id, $trainee_id)
    {
        try
        {
            $current_attendance = $attendance->where('class_id', $class_id)->where('trainee_id', $trainee_id)->first();

            if(!$current_attendance)
            {
                return response(['message' => 'Trainee not found in the given class.'], 400);
            }
            
            $session_notes = $session_note->where('attend_id', $current_attendance->id)->get();

            $sessions_collection = [];

            foreach((object) $session_notes as $key => $s_note)
            {
                $sessions_collection[$key] = ['id' => $s_note->id, 'session_title' => $s_note->session_title, 'session_status' => $s_note->session_status];
            }

            return response($sessions_collection, 200);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Session notes cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}