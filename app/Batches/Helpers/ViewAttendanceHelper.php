<?php

namespace App\Batches\Helpers;

trait ViewAttendanceHelper
{
    protected function viewAttendance($attendances, $class_id, $class)
    {
        $attendances_data = [];
        
        $current_attendance = $attendances->where("class_id", $class_id)->get();

        $attendances_data = $class?->getCollection($current_attendance, $class);

        $num_attendance = $current_attendance->count();

        $message = $num_attendance === 0 ? response(['message' => "Attendance is empty."], 200) : response($attendances_data, 200);

        return $message;
    }
}