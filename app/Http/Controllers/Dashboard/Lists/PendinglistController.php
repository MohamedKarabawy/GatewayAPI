<?php

namespace App\Http\Controllers\Dashboard\Lists;

use App\Models\User;
use App\Models\Trainee;
use App\Models\Permission;
use App\Models\GeneralMeta;
use App\Models\TraineeMeta;
use Illuminate\Http\Request;
use App\Trainees\Pendinglist\View;
use App\Http\Controllers\Controller;
use App\Trainees\Pendinglist\Create;
use App\Trainees\Pendinglist\Update;
use App\Trainees\Pendinglist\Show\Levels;
use App\Trainees\Pendinglist\Show\FollowUp;
use App\Trainees\Pendinglist\Show\Trainers;
use App\Trainees\Pendinglist\Deletes\Delete;
use App\Trainees\Pendinglist\Assign\AssignLevel;
use App\Trainees\Pendinglist\Deletes\BulkDelete;

class PendinglistController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
    }

    public function assignLevel(?Trainee $trainee, ?GeneralMeta $level, Request $request, $trainee_id)
    {
        $this->trainee['assign-level'] = new AssignLevel($trainee, $trainee_id);

        return $this->trainee['assign-level']->assign($trainee, $level, $request, $trainee_id);
    }

    public function viewFollowUp(?Trainee $trainee, ?User $user, ?Permission $permission)
    {
        $this->trainee['follow_up'] = new FollowUp($trainee);

        return $this->trainee['follow_up']->show($user, $permission);
    }

    public function viewLevels(?Trainee $trainee, ?GeneralMeta $level)
    {
        $this->trainee['levels'] = new Levels($trainee);

        return $this->trainee['levels']->viewLevels($level);
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