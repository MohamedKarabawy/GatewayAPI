<?php

namespace App\Http\Controllers\Dashboard\Trainees;

use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TraineesData\ViewTraineeData;

class TraineesController extends Controller
{
    public function view(?Trainee $trainee)
    {
        $this->trainees['view'] = new ViewTraineeData($trainee);

        return $this->trainees['view']->viewTraineeData($trainee);
    }
}