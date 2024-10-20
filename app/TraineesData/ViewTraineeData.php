<?php

namespace App\TraineesData;

use Exception;
use App\Models\Trainee;
use App\Traits\GetUser;
use App\Traits\GetClass;
use App\Traits\GetListById;
use App\Traits\GetBranchByID;
use App\Traits\GetGeneralMeta;
use Illuminate\Support\Facades\Gate;

class ViewTraineeData
{
    use GetUser, GetBranchByID, GetListById, GetClass, GetGeneralMeta;
    
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('viewTrainees', $trainee);
    }

    public function viewTraineeData(?Trainee $trainee)
    {
        try
        {
            $trainees = $trainee->get();

            $trainees_collection = [];

            $meta_collection = [];

            $follow_up_collection = [];

            foreach ($trainees as $key => $g_trainee)
            {
                $g_trainee->current_list !== null ? $status = $this->List($g_trainee->current_list)?->list_title : $status = $this->getClass($g_trainee->id)?->class_name;
                
                $status === 'Pending List' &&  $follow_up_collection = ['follow_up' => $this->User($g_trainee->follow_up)?->full_name];
                
                foreach($g_trainee->trainee_meta as $meta)
                {
                    $meta_collection[$meta->meta_key] = $meta->meta_value;
                }
                
                $trainees_collection[$key] = [
                    'id' => $g_trainee->id,
                    'status' => $status,
                    'full_name' => $g_trainee?->full_name,
                    'attend_type' => $g_trainee?->attend_type,
                    'test_date' => $g_trainee?->test_date,
                    'branch' => $this->Branch($g_trainee?->branch_id)->district,
                    'trainer' => $g_trainee?->user?->full_name,
                    'payment_type' => $this->GetGeneralMeta($g_trainee?->payment_type)?->meta_value,
                    ...$follow_up_collection,
                    ...$meta_collection
                ];

                $meta_collection = [];
            }

            return response($trainees_collection, 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Trainees cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}