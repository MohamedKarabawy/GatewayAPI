<?php

namespace App\Trainees\Pendinglist;

use App\Models\Trainee;
use App\Traits\GetList;
use App\Traits\GetUser;
use App\Traits\GetBranch;
use App\Traits\CreateMeta;
use App\Models\TraineeMeta;
use Illuminate\Http\Request;
use App\Traits\GetGeneralMeta;
use App\Permissions\Permissions;
use App\Traits\PermissionUniqueness;
use Illuminate\Support\Facades\Gate;
use App\Trainees\Helpers\TraineeDataHelper;
use App\Trainees\Helpers\StoreTraineeAddtionalData;
use App\Trainees\Helpers\StoreTraineeEssentialData;

class Create extends permissions
{
    use GetUser, GetGeneralMeta, StoreTraineeEssentialData, StoreTraineeAddtionalData, GetBranch, GetList, CreateMeta, PermissionUniqueness;

    public function __construct(?Trainee $trainee, $current_user)
    {
        Gate::authorize('createPendingTrainee', $trainee);

        $this->current_user = $current_user;

        $this->permission_collection = 'pendinglist';

        $this->list = "Pending List";

        $this->payment_collection = "payment_type";

        $this->level_collection = "pendinglist_level";

        //'test_date' made a single column for it

        $this->meta_keys = ['country', 'age_group', 'job', 'education', 'email', 'city', 'brith_date', 'paid_value', 'remaining_value', 'confirmation'];
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