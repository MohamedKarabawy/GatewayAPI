<?php

namespace App\Trainees\Pendinglist;

use App\Models\Trainee;
use App\Traits\GetList;
use App\Traits\GetUser;
use App\Traits\GetBranch;
use App\Traits\CreateMeta;
use App\Traits\UpdateMeta;
use App\Models\TraineeMeta;
use Illuminate\Http\Request;
use App\Traits\GetGeneralMeta;
use App\Permissions\Permissions;
use App\Traits\PermissionUniqueness;
use Illuminate\Support\Facades\Gate;
use App\Trainees\Helpers\TraineeDataHelper;
use App\Trainees\Helpers\UpdateTraineeAddtionalData;
use App\Trainees\Helpers\UpdateTraineeEssentialData;

class Update extends Permissions
{
    use GetUser, GetGeneralMeta, UpdateTraineeEssentialData, UpdateTraineeAddtionalData, GetBranch, GetList, CreateMeta, UpdateMeta, PermissionUniqueness;

    public function __construct(?Trainee $trainee, $current_user, $id)
    {
        Gate::authorize('updatePendingTrainee', $trainee->find($id));

        $this->current_user = $current_user;

        $this->permission_collection = 'pendinglist';

        $this->payment_collection = "payment_type";

        $this->level_collection = "pendinglist_level";

        $this->meta_keys = ['confirmation','country', 'age_group', 'job', 'education', 'email', 'city', 'birth_date', 'paid_value', 'remaining_value'];

        $this->permissions = ['update_all', 'update_own'];
    }

    public function update(?Trainee $trainee, ?TraineeMeta $TraineeMeta, Request $request, $id)
    {
        try
        {
            $this->UpdateTraineeEssentialData($trainee->find($id), $request, $this);

            $this->UpdateTraineeAddtionalData($TraineeMeta, $trainee->find($id)->id, $request, $this);

            return response(['message' => "Trainee updated successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The trainee cannot be updated. Please contact the administrator of the website."], 400);
        }
    }
}