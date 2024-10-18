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
        $this->permissions = ['view' => ['view_attendance'],
        'add-to-attendance' => ['add_to_attendance'],
        'add-session-notes' => ['add_session_notes'],
        'view-session-notes' => ['view_session_notes']];
        
        $this->permission_collection['attendance'] = 'attendance';

        $this->permission_collection['classes'] = 'classes';

    }

    public function addSessionNotes(?User $current_user, ?Attendance $attendance)
    {
        return $this->CheckPermission($current_user, $this->permissions['add-session-notes'], $this->permission_collection['attendance']);
    }

    public function viewSessionNotes(?User $current_user, ?Attendance $attendance)
    {
        return $this->CheckPermission($current_user, $this->permissions['view-session-notes'], $this->permission_collection['attendance']);
    }

    public function viewAttendance(?User $current_user, ?Attendance $attendance)
    {
        return $this->CheckPermission($current_user, $this->permissions['view'], $this->permission_collection['attendance']);
    }

    public function addToAttendance(?User $current_user, ?Attendance $attendance)
    {
        return $this->CheckPermission($current_user, $this->permissions['add-to-attendance'], $this->permission_collection['classes']);
    }

}