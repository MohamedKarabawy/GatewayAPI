<?php

namespace App\Batches\Helpers;

trait ViewBatchesHelper
{
    protected function viewBatches($batches, $class)
    {
        $batches_data = [];

        $class->CheckPermissionStatus($class->current_user, $class->permission_collection, 'view_trainees') && $batches_data = $class?->getCollection($batches?->get(), $class);

        ($class->CheckPermissionStatus($class->current_user, $class->permission_collection, 'view_own_trainees') && count($batches_data) === 0) &&

        $batches_data = $class?->getCollection($batches->where('user_id', $class->current_user->id)->get(), $class);

        $num_batches = $batches->count();

        $sub_message = $num_batches === 0 ?  response(['message' => "There's no batches available."], 200) : response(['message' => 'Unauthorized'], 401);

        $message = count($batches_data) === 0 ? $sub_message : response($batches_data, 200);

        return $message;
    }
}