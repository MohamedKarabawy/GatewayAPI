<?php

namespace App\Traits;

use App\Models\Batch;
use App\Models\Classes;
use App\Models\TraineeClass;

trait GetClass
{
    protected function getClass($id)
    {
        $trainee_class = TraineeClass::where('trainee_id', $id)->first();

        $current_batch = Batch::where('is_active', true)->first();

        $class = Classes::where('batch_id', $current_batch->id)->where('id', $trainee_class?->class_id)->first();

        return $class;
    }
}