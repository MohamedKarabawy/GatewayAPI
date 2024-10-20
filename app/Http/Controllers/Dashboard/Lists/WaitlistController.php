<?php

namespace App\Http\Controllers\Dashboard\Lists;

use App\Models\User;
use App\Models\Batch;
use App\Models\Classes;
use App\Models\Trainee;
use App\Models\ClassMeta;
use App\Models\Permission;
use App\Models\GeneralMeta;
use App\Models\TraineeMeta;
use App\Models\TraineeClass;
use Illuminate\Http\Request;
use App\Trainees\Waitlist\View;
use App\Trainees\Waitlist\Create;
use App\Trainees\Waitlist\Update;
use App\Http\Controllers\Controller;
use App\Trainees\Waitlist\Add\AddLevel;
use App\Trainees\Waitlist\Show\Trainers;
use App\Trainees\Waitlist\Deletes\Delete;
use App\Trainees\Waitlist\Move\Bulk\Hold;
use App\Trainees\Waitlist\Move\Bulk\Black;
use App\Trainees\Waitlist\Move\MoveToHold;
use App\Trainees\Waitlist\View\ViewLevels;
use App\Trainees\Waitlist\Move\Bulk\Refund;
use App\Trainees\Waitlist\Show\ViewClasses;
use App\Trainees\Waitlist\Move\MoveToRefund;
use App\Trainees\Waitlist\Add\AddPaymentType;
use App\Trainees\Waitlist\Assign\AssignClass;
use App\Trainees\Waitlist\Deletes\BulkDelete;
use App\Trainees\Waitlist\Move\MoveToBlacklist;
use App\Trainees\Waitlist\Show\ViewCLassesTime;
use App\Trainees\Waitlist\Add\AddPreferableTime;
use App\Trainees\Waitlist\View\ViewPaymentTypes;
use App\Trainees\Waitlist\Show\ViewClassesLevels;
use App\Trainees\Waitlist\View\ViewPreferableTimes;

class WaitlistController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
    }

    public function viewClasses(?Trainee $trainee, ?Classes $class, ?Batch $batch, Request $request)
    {
        $this->trainee['view-classes'] = new ViewClasses($trainee);

        return $this->trainee['view-classes']->viewClasses($class, $batch, $request);
    }

    public function viewClassesLevels(?Trainee $trainee, ?ClassMeta $meta)
    {
        $this->trainee['view-classes-levels'] = new ViewClassesLevels($trainee);

        return $this->trainee['view-classes-levels']->viewClassesLevels($meta);
    }

    public function viewClassesTimes(?Trainee $trainee, ?ClassMeta $meta)
    {
        $this->trainee['view-classes-times'] = new ViewCLassesTime($trainee);

        return $this->trainee['view-classes-times']->viewClassesTime($meta);
    }

    public function viewLevels(?Trainee $trainee, ?GeneralMeta $meta)
    {
        $this->trainee['view-levels'] = new ViewLevels($trainee);

        return $this->trainee['view-levels']->viewLevels($meta);
    }

    public function viewPayment(?Trainee $trainee, ?GeneralMeta $meta)
    {
        $this->trainee['view-payment'] = new ViewPaymentTypes($trainee);

        return $this->trainee['view-payment']->viewPaymentTypes($meta);
    }

    public function viewTimes(?Trainee $trainee, ?GeneralMeta $meta, Request $request)
    {
        $this->trainee['view-time'] = new ViewPreferableTimes($trainee);

        return $this->trainee['view-time']->viewPreferableTimes($meta, $request);
    }

    public function addLevel(?Trainee $trainee, ?GeneralMeta $meta, Request $request)
    {
        $this->trainee['add-level'] = new AddLevel($trainee);

        return $this->trainee['add-level']->addLevel($meta, $request);
    }

    public function addPayment(?Trainee $trainee, ?GeneralMeta $meta, Request $request)
    {
        $this->trainee['add-payment'] = new AddPaymentType($trainee);

        return $this->trainee['add-payment']->addPaymentType($meta, $request);
    }

    public function addTime(?Trainee $trainee, ?GeneralMeta $meta, Request $request)
    {
        $this->trainee['add-time'] = new AddPreferableTime($trainee);

        return $this->trainee['add-time']->addPreferableTime($meta, $request);
    }

    public function assignClass(?Trainee $trainee, ?TraineeClass $trainee_class, Request $request, $trainee_id)
    {
        $this->trainee['assign-class'] = new AssignClass($trainee, $trainee_id);

        return $this->trainee['assign-class']->assign($trainee, $trainee_class, $request, $trainee_id);
    }

    public function bulkMoveToHold(?Trainee $trainee, Request $request)
    {
        $this->trainee['hold'] = new Hold($this->current_user);

        return $this->trainee['hold']->move($trainee, $request);
    }

    public function bulkMoveToRefund(?Trainee $trainee, Request $request)
    {
        $this->trainee['refund'] = new Refund($this->current_user);

        return $this->trainee['refund']->move($trainee, $request);
    }

    public function bulkMoveToBlack(?Trainee $trainee, Request $request)
    {
        $this->trainee['black'] = new Black($this->current_user);

        return $this->trainee['black']->move($trainee, $request);
    }

    public function moveToHold(?Trainee $trainee, $id)
    {
        $this->trainee['move-to-hold'] = new MoveToHold($trainee, $id);

        return $this->trainee['move-to-hold']->move($trainee, $id);
    }

    public function moveToRefund(?Trainee $trainee, $id)
    {
        $this->trainee['move-to-refund'] = new MoveToRefund($trainee, $id);

        return $this->trainee['move-to-refund']->move($trainee, $id);
    }

    public function moveToBlack(?Trainee $trainee, $id)
    {
        $this->trainee['move-to-black'] = new MoveToBlacklist($trainee, $id);

        return $this->trainee['move-to-black']->move($trainee, $id);
    }
    
    public function viewTrainers(?Trainee $trainee, ?User $user, ?Permission $permission)
    {
        $this->trainee['trainers'] = new Trainers($trainee);

        return $this->trainee['trainers']->show($user, $permission);
    }

    public function view(?Trainee $trainee)
    {
        $this->trainee['view'] = new View($this->current_user);

        return $this->trainee['view']->view($trainee);
    }

    public function create(?Trainee $trainee, ?TraineeMeta $TraineeMeta, Request $request)
    {
        $this->trainee['create'] = new Create($trainee, $this->current_user);

        return $this->trainee['create']->create($trainee, $TraineeMeta, $request);
    }

    public function update(?Trainee $trainee, ?TraineeMeta $TraineeMeta, Request $request, $id)
    {
        $this->trainee['update'] = new Update($trainee, $this->current_user, $id);

        return $this->trainee['update']->update($trainee, $TraineeMeta, $request, $id);
    }
    
    public function delete(?Trainee $trainee, $id)
    {
        $this->trainee['delete'] = new Delete($trainee, $id);

        return $this->trainee['delete']->delete($trainee, $id);
    }

    public function bulkDelete(?Trainee $trainee, Request $request)
    {
        $this->trainee['delete'] = new BulkDelete();

        return $this->trainee['delete']->delete($trainee, $request);
    }
}