<?php

namespace App\Http\Controllers\Dashboard\Batches\Classes;

use App\Models\Classes;
use App\Models\TraineeClass;
use Illuminate\Http\Request;
use App\Batches\Classes\Class\View;
use App\Http\Controllers\Controller;
use App\Batches\Classes\Class\ViewSelectClasses;

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

    public function viewClasses(Classes $class, $batch_id)
    {
        $this->class['view-classes'] = new ViewSelectClasses($this->current_user);

        return $this->class['view-classes']->view($class, $batch_id);
    }
}