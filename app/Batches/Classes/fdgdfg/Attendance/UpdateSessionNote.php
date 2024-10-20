<?php

namespace App\Batches\Classes\Class\Attendance;

use Exception;
use App\Models\Attendance;
use App\Models\SessionNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class UpdateSessionNote
{
    public function __construct(Attendance $attendance)
    {
        Gate::authorize('addSessionNotes', $attendance);
    }

    public function updateSessionNote(SessionNote $session_note, Request $request, $session_id)
    {
        try
        {
            $current_session_note = $session_note->where('id', $session_id);
            
            if(!$current_session_note->exists())
            {
                return response(['message' => 'Session does not exist'], 400);
            }

            $current_session = $current_session_note->first();

            $request->filled('session_title') && $current_session->session_title = $request->session_title;

            $request->filled('session_status') && $current_session->session_status = $request->session_status;

            $current_session->save();

            return response(['message' => 'Session note updated successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Session note cannot be updated. Please contact the administrator of the website."], 400);
        }
    }
}