<?php

namespace App\Http\Controllers\Dashboard\Batches\Classes;

use App\Models\User;
use App\Models\Classes;
use App\Models\Trainee;
use App\Models\ClassMeta;
use App\Models\Permission;
use App\Models\TraineeClass;
use Illuminate\Http\Request;
use App\Batches\Classes\View;
use App\Batches\Classes\Create;
use App\Batches\Classes\Delete;
use App\Batches\Classes\Update;
use App\Batches\Classes\Add\Gates;
use App\Batches\Classes\Add\Level;
use App\Http\Controllers\Controller;
use App\Batches\Classes\Add\TimeSlot;
use App\Batches\Classes\View\ViewGates;
use App\Batches\Classes\View\ViewLevels;
use App\Batches\Classes\View\ViewTrainers;
use App\Batches\Classes\View\ViewTimeSlots;
use App\Batches\Classes\Class\Move\MoveToHold;
use App\Batches\Classes\Class\Move\MoveToWait;
use App\Batches\Classes\Class\Move\MoveToBlack;
use App\Batches\Classes\Class\Move\SwitchClass;
use App\Batches\Classes\Class\Move\MoveToRefund;

class ClassesController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
    }

    public function moveToBlack(?Classes $class, ?Trainee $trainees, ?TraineeClass $trainee_class, $class_id, $trainee_id)
    {
        $this->class['move-to-black'] = new MoveToBlack($class);

        return $this->class['move-to-black']->moveToBlack($trainees, $trainee_class, $class_id, $trainee_id);
    }

    public function moveToHold(?Classes $class, ?Trainee $trainees, ?TraineeClass $trainee_class, $class_id, $trainee_id)
    {
        $this->class['move-to-hold'] = new MoveToHold($class);

        return $this->class['move-to-hold']->moveToHold($trainees, $trainee_class, $class_id, $trainee_id);
    }
    
    public function moveToRefund(?Classes $class, ?Trainee $trainees, ?TraineeClass $trainee_class, $class_id, $trainee_id)
    {
        $this->class['move-to-refund'] = new MoveToRefund($class);

        return $this->class['move-to-refund']->moveToRefund($trainees, $trainee_class, $class_id, $trainee_id);
    }

    public function moveToWait(?Classes $class, ?Trainee $trainees, ?TraineeClass $trainee_class, $class_id, $trainee_id)
    {
        $this->class['move-to-wait'] = new MoveToWait($class);

        return $this->class['move-to-wait']->moveToWait($trainees, $trainee_class, $class_id, $trainee_id);
    }

    public function switchClass(?Classes $class, ?TraineeClass $trainee_class, Request $request, $trainee_id)
    {
        $this->class['switch-class'] = new SwitchClass($class);

        return $this->class['switch-class']->switchClass($trainee_class, $request, $trainee_id);
    }

    public function viewGates(?ClassMeta $gate, ?Classes $class)
    {
        $this->class['gate'] = new ViewGates($class);

        return $this->class['gate']->viewGates($gate);
    }

    public function viewLevels(?ClassMeta $level, ?Classes $class)
    {
        $this->class['level'] = new ViewLevels($class);

        return $this->class['level']->viewLevels($level);
    }

    public function viewTimeSlots(?ClassMeta $time_slot, ?Classes $class)
    {
        $this->class['time_slot'] = new ViewTimeSlots($class);

        return $this->class['time_slot']->viewTimeSlots($time_slot);
    }

    public function viewTrainers(?Classes $class, ?User $user, ?Permission $permission)
    {
        $this->class['trainer'] = new ViewTrainers($class);

        return $this->class['trainer']->show($user, $permission);
    }

    public function createGate(?ClassMeta $gate, Request $request, ?Classes $class)
    {
        $this->class['gate'] = new Gates($class);

        return $this->class['gate']->add($gate, $request);
    }

    public function createLevel(?ClassMeta $level, Request $request, ?Classes $class)
    {
        $this->class['level'] = new Level($class);

        return $this->class['level']->add($level, $request);
    }

    public function createTimeSlot(?ClassMeta $time_slot, Request $request, ?Classes $class)
    {
        $this->class['time_slot'] = new TimeSlot($class);

        return $this->class['time_slot']->add($time_slot, $request);
    }

    public function viewClasses(?Classes $classes, $batch_id)
    {
        $this->class['view'] = new View($this->current_user);

        return $this->class['view']->view($classes, $batch_id);
    }

    public function createClass(?Classes $class, ?User $user, ?ClassMeta $class_meta, Request $request, $batch_id)
    {
        $this->class['create'] = new Create($class, $this->current_user);

        return $this->class['create']->create($class, $user, $class_meta, $request, $batch_id);
    }

    public function updateClass(?Classes $class, ?User $user, ?ClassMeta $class_meta, Request $request, $batch_id, $class_id)
    {
        $this->class['update'] = new Update($class, $this->current_user, $class_id);

        return $this->class['update']->update($class, $user, $class_meta, $request, $batch_id, $class_id);
    }

    public function deleteClass(?Classes $class, $batch_id, $class_id)
    {
        $this->class['update'] = new Delete($class, $class_id);

        return $this->class['update']->delete($class, $batch_id, $class_id);
    }
}