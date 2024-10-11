<?php

namespace App\Http\Controllers\Dashboard\Batches\classes;

use App\Models\User;
use App\Models\Classes;
use App\Models\ClassMeta;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Batches\Classes\View;
use App\Batches\Classes\Create;
use App\Batches\Classes\Delete;
use App\Batches\Classes\Update;
use App\Batches\Classes\Add\Gate;
use App\Batches\Classes\Add\Level;
use App\Http\Controllers\Controller;
use App\Batches\Classes\Add\TimeSlot;
use App\Batches\Classes\View\ViewGates;
use App\Batches\Classes\View\ViewLevels;
use App\Batches\Classes\View\ViewTrainers;
use App\Batches\Classes\View\ViewTimeSlots;

class ClassesController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
    }

    public function viewGates(?ClassMeta $gate)
    {
        $this->class['gate'] = new ViewGates($gate);

        return $this->class['gate']->viewGates($gate);
    }

    public function viewLevels(?ClassMeta $level)
    {
        $this->class['level'] = new ViewLevels($level);

        return $this->class['level']->viewLevels($level);
    }

    public function viewTimeSlots(?ClassMeta $time_slot)
    {
        $this->class['time_slot'] = new ViewTimeSlots($time_slot);

        return $this->class['time_slot']->viewTimeSlots($time_slot);
    }

    public function viewTrainers(?Classes $class, ?User $user, ?Permission $permission)
    {
        $this->class['trainer'] = new ViewTrainers($class);

        return $this->class['trainer']->show($user, $permission);
    }

    public function createGate(?ClassMeta $gate, Request $request)
    {
        $this->class['gate'] = new Gate($gate);

        return $this->class['gate']->add($gate, $request);
    }

    public function createLevel(?ClassMeta $level, Request $request)
    {
        $this->class['level'] = new Level($level);

        return $this->class['level']->add($level, $request);
    }

    public function createTimeSlot(?ClassMeta $time_slot, Request $request)
    {
        $this->class['time_slot'] = new TimeSlot($time_slot);

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

    public function updateClass(?Classes $class, Request $request, $batch_id, $class_id)
    {
        $this->class['update'] = new Update($class, $this->current_user, $class_id);

        return $this->class['update']->update($class, $request, $batch_id, $class_id);
    }

    public function deleteClass(?Classes $class, Request $request, $batch_id, $class_id)
    {
        $this->class['update'] = new Delete($class, $this->current_user, $class_id);

        return $this->class['update']->delete($class, $batch_id, $class_id);
    }
}