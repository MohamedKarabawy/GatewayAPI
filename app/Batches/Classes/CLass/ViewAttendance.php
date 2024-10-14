<?php

namespace App\Batches\Classes\Class;

use Exception;
use App\Models\Attendance;
use Illuminate\Support\Facades\Gate;
use App\Traits\CheckPermissionStatus;
use App\Batches\Helpers\GetAttendance;
use App\Batches\Helpers\ViewAttendanceHelper;


class ViewAttendance
{
    use CheckPermissionStatus, GetAttendance, ViewAttendanceHelper;

    public function __construct(?Attendance $attendance, $current_user)
    {
        Gate::authorize('viewAttendance', $attendance);
    }

    public function view(?Attendance $attendance, $class_id)
    {
        try
        {
            return $this->viewAttendance($attendance, $class_id, $this);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Attendance cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}