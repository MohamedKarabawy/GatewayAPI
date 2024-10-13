<?php

namespace App\Http\Controllers\Dashboard\Batches\Classes;

use App\Models\Classes;
use App\Models\TraineeClass;
use Illuminate\Http\Request;
use App\Batches\Classes\Class\View;
use App\Http\Controllers\Controller;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
    }


    public function viewClass(?Classes $class, ?TraineeClass $trainee, $batch_id, $class_id)
    {
        $this->class['view'] = new View($this->current_user);

        return $this->class['view']->view($class, $trainee, $batch_id, $class_id);
    }
}