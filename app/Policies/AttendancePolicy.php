<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attendance;
use App\Traits\CheckPermission;
use Illuminate\Auth\Access\Response;

class AttendancePolicy
{
    use CheckPermission;
    
    public function __construct()
    {
        $this->permissions = ['view' => ['view_attendance']];
        $this->permission_collection = 'attendance';
    }

    public function viewAttendance(?User $current_user, ?Attendance $attendance)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection);
    }

}