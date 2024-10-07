<?php

namespace App\Trainees\Waitlist;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\TraineeMeta;
use Illuminate\Support\Facades\Gate;
use App\Traits\GetBranch;
use App\Traits\GetList;
use App\Traits\CreateMeta;
use App\Traits\PermissionUniqueness;
use App\Permissions\Permissions;
use App\Trainees\Helpers\StoreTraineeEssentialData;
use App\Trainees\Helpers\StoreTraineeAddtionalData;
use App\Trainees\Helpers\TraineeDataHelper;

class Create extends permissions
{
    use TraineeDataHelper, StoreTraineeEssentialData, StoreTraineeAddtionalData, GetBranch, GetList, CreateMeta, PermissionUniqueness;

    public function __construct(?Trainee $trainee, $current_user)
    {
        Gate::authorize('createTrainee', $trainee);

        $this->current_user = $current_user;

        $this->permission_collection = 'waitlist';

        $this->list = "Wait List";

        $this->payment_collection = "payment_type";

        $this->level_collection = "waitlist_level";

        $this->meta_keys = ['country', 'age_group', 'test_date', 'preferable_time', 'sec_preferable_time', 'job', 'education', 'email', 'city', 'brith_date', 'paid_value', 'remaining_value'];
    }

    public function create(?Trainee $trainee, ?TraineeMeta $TraineeMeta, Request $request)
    {
        try
        {
            $created_trainee = $this->StoreTraineeEssentialData($trainee, $request, $this);

            $this->StoreTraineeAddtionalData($TraineeMeta, $created_trainee->id, $request, $this);

            return response(['message' => "Trainee created successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The trainee cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}