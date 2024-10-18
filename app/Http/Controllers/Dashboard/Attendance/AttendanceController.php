<?php

namespace App\Http\Controllers\Dashboard\Attendance;

use App\Models\Attendance;
use App\Models\SessionNote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batches\Classes\Class\Add\AddToAttendance;
use App\Batches\Classes\Class\Attendance\AddSessionNote;
use App\Batches\Classes\Class\Attendance\ViewAttendance;
use App\Batches\Classes\Class\Attendance\UpdateSessionNote;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
    }

    public function viewSessionNote(SessionNote $session_note, Attendance $attendance, $class_id, $trainee_id)
    {
        $this->attendance['view-session-notes'] = new ViewSessionNote($attendance);

        return $this->attendance['view-session-notes']->viewSessionNote($session_note, $attendance, $class_id, $trainee_id);
    }

    public function addSessionNote(SessionNote $session_note, Attendance $attendance, Request $request, $class_id, $trainee_id)
    {
        $this->attendance['add-session-notes'] = new AddSessionNote($attendance);

        return $this->attendance['add-session-notes']->addSessionNote($session_note, $attendance, $request, $class_id, $trainee_id);
    }

    public function updateSessionNote(SessionNote $session_note, Request $request, $session_id)
    {
        $this->attendance['update-session-notes'] = new UpdateSessionNote($attendance);

        return $this->attendance['update-session-notes']->updateSessionNote($session_note, $request, $session_id);
    }

    public function view(?Attendance $attendance, $class_id)
    {
        $this->attendance['view'] = new ViewAttendance($attendance, $this->current_user);

        return $this->attendance['view']->view($attendance, $class_id);
    }

    public function addToAttendance(?Attendance $attendance, $class_id, $trainee_id)
    {
        $this->attendance['add'] = new AddToAttendance($attendance, $this->current_user);

        return $this->attendance['add']->addToAttendance($attendance, $class_id, $trainee_id);
    }
}