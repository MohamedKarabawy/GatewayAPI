<?php

namespace App\Trainees\Helpers;

trait StoreTraineeEssentialData
{
    protected function StoreTraineeEssentialData($trainee, $request, $class)
    {
        count($request->all()) >= 2 && $trainee->user_id = $class->current_user->id;

        $request->has('branch') && $trainee->branch_id = $class->Branch($request->branch)->id;

        $request->has('full_name') && $trainee->full_name = $request->full_name;

        $request->has('notes') && $trainee->notes = $request->notes;

        $request->has('attend_type') && $trainee->attend_type = $request->attend_type;

        $request->has('payment_type') && $trainee->payment_type = $class->GetGeneralMeta($class->payment_collection, $request->payment_type)->id;

        count($request->all()) >= 2 && $class->TraineeDataHelper($trainee, $request, 'assign', $class);

        count($request->all()) >= 2 && $trainee->current_list = $class->List($class->list)->id;

        count($request->all()) >= 2 && $trainee->save();

        return $trainee;
    }
}