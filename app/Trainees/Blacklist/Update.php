<?php

namespace App\Trainees\Blacklist;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\TraineeMeta;
use Illuminate\Support\Facades\Gate;
use App\Traits\GetBranch;
use App\Traits\GetList;
use App\Traits\CreateMeta;
use App\Traits\UpdateMeta;
use App\Traits\PermissionUniqueness;
use App\Permissions\Permissions;
use App\Trainees\Helpers\UpdateTraineeEssentialData;
use App\Trainees\Helpers\UpdateTraineeAddtionalData;
use App\Trainees\Helpers\TraineeDataHelper;

class Update extends Permissions
{
    use TraineeDataHelper, UpdateTraineeEssentialData, UpdateTraineeAddtionalData, GetBranch, GetList, CreateMeta, UpdateMeta, PermissionUniqueness;

    public function __construct(?Trainee $trainee, $current_user, $id)
    {
        Gate::authorize('updateBlackTrainee', $trainee->find($id));

        $this->current_user = $current_user;

        $this->permission_collection = 'blacklist';

        $this->payment_collection = "payment_type";

        $this->level_collection = "waitlist_level";

        $this->meta_keys = ['country', 'age_group', 'test_date', 'preferable_time', 'sec_preferable_time', 'job', 'education', 'email', 'city', 'brith_date', 'paid_value', 'remaining_value'];

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