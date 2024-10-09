<?php

namespace App\Http\Controllers\Dashboard\Lists;

use App\Models\User;
use App\Models\Trainee;
use App\Models\Permission;
use App\Models\TraineeMeta;
use Illuminate\Http\Request;
use App\Trainees\Waitlist\View;
use App\Trainees\Waitlist\Create;
use App\Trainees\Waitlist\Update;
use App\Http\Controllers\Controller;
use App\Trainees\Waitlist\Show\Trainers;
use App\Trainees\Waitlist\Deletes\Delete;
use App\Trainees\Waitlist\Deletes\BulkDelete;
use App\Trainees\Waitlist\Move\MoveToHold;
use App\Trainees\Waitlist\Move\MoveToRefund;
use App\Trainees\Waitlist\Move\MoveToBlacklist;

class WaitlistController extends Controller
{
    public function __construct()
    {
        $this->current_user = auth()->user();
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