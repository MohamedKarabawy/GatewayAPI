<?php

namespace App\Http\Controllers\Dashboard\Attendance;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batches\Classes\Class\ViewAttendance;
use App\Batches\Classes\Class\Add\AddToAttendance;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
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