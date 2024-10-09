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

        $current_list = $trainees?->where('current_list', $class->List($class->list)->id)->count();

        $sub_message = $current_list === 0 ?  response(['message' => 'This list is empty'], 200) : response(['message' => 'Unauthorized'], 401);

        $message = count($trainees_data) === 0 ? $sub_message : response(['trainees' => $trainees_data], 201);

        return $message;
    }
}