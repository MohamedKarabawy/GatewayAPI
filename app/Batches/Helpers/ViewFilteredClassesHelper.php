<?php

namespace App\Batches\Helpers;

trait ViewFilteredClassesHelper
{
    protected function viewClasses($classes, $batch, $request, $batch_id, $class)
    {
        $classes_data = [];

        $class->CheckPermissionStatus($class->current_user, $class->permission_collection, 'view_classes') && $classes_data = $class?->getCollection($classes, $batch, $request, $batch_id, $class);

        ($class->CheckPermissionStatus($class->current_user, $class->permission_collection, 'view_own_classes') && count($classes_data) === 0) &&

        $classes_data = $class?->getCollection($classes, $batch, $request, $batch_id, $class, $class->current_user);

        $num_classes = count($class?->getCollection($classes, $batch, $request, $batch_id, $class));

        $sub_message = $num_classes === 0 ?  response(['message' => "There's no classes available."], 200) : response(['message' => 'Unauthorized'], 401);

        $message = count($classes_data) === 0 ? $sub_message : response($classes_data, 200);

        return $message;
    }
}