<?php

namespace App\Trainees\Helpers;

trait ViewTraineesHelper
{
    protected function viewTrainees($trainees, $class)
    {
        $trainees_data = [];

        $class->CheckPermissionStatus($class->current_user, $class->permission_collection, 'view_trainees') && $trainees_data = $class->getCollection($trainees?->get(), $class);

        ($class->CheckPermissionStatus($class->current_user, $class->permission_collection, 'view_own_trainees') && count($trainees_data) === 0) &&

        $trainees_data = $class?->getCollection($trainees->where('user_id', $class->current_user->id)->get(), $class);

        $message = count($trainees_data) === 0 ? response(['message' => 'Unauthorized'], 401) : response(['trainees' => $trainees_data], 201);

        return $message;
    }
}