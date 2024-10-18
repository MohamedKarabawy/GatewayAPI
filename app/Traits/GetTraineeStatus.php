<?php

namespace App\Traits;

use App\Model\Classes;


trait GetTraineeStatus
{
    protected function status($trainee_id)
    {
        return Classes::where('trainee_id', $trainee_id)->count();
    }
}