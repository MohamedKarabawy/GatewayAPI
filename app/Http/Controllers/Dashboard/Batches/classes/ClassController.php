<?php

namespace App\Http\Controllers\Dashboard\Batches\Classes;

use App\Models\Classes;
use App\Models\Attendance;
use App\Models\TraineeClass;
use Illuminate\Http\Request;
use App\Batches\Classes\Class\View;
use App\Http\Controllers\Controller;
use App\Batches\Classes\Class\ViewAdminNote;
use App\Batches\Classes\Class\ViewTrainerNote;
use App\Batches\Classes\Class\Add\AddAdminNote;
use App\Batches\Classes\Class\ViewSelectClasses;
use App\Batches\Classes\Class\Add\AddTrainerNote;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
    }

    public function viewAdminNote(?Classes $class, ?Attendance $attendance, $class_id, $trainee_id)
    {
        $this->class['view-admin-note'] = new ViewAdminNote($class);

        return $this->class['view-admin-note']->view($attendance, $class_id, $trainee_id);
    }

    public function viewTrainerNote(?Classes $class, ?Attendance $attendance, $class_id, $trainee_id)
    {
        $this->class['view-trainer-note'] = new ViewTrainerNote($class);

        return $this->class['view-trainer-note']->view($attendance, $class_id, $trainee_id);
    }

    public function addAdminNote(?Classes $class, ?Attendance $attendance, Request $request, $class_id, $trainee_id)
    {
        $this->class['add-admin-note'] = new AddAdminNote($class);

        return $this->class['add-admin-note']->addAdminNote($attendance, $request, $class_id, $trainee_id);
    }

    public function addTrainerNote(?Classes $class, ?Attendance $attendance, Request $request, $class_id, $trainee_id)
    {
        $this->class['add-admin-note'] = new AddTrainerNote($class);

        return $this->class['add-admin-note']->addTrainerNote($attendance, $request, $class_id, $trainee_id);
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