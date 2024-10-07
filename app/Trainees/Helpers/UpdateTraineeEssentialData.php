<?php

namespace App\Trainees\Helpers;

trait UpdateTraineeEssentialData
{
    protected function UpdateTraineeEssentialData($trainee, $request, $class)
    {
        $request->has('branch') && $trainee->branch_id = $class->Branch($request->branch)->id;

        $request->has('full_name') && $trainee->full_name = $request->full_name;

        $request->has('notes') && $trainee->notes = $request->notes;

        $request->has('attend_type') && $trainee->attend_type = $request->attend_type;

        $request->has('payment_type') && $trainee->payment_type = $class->GetGeneralMeta($class->payment_collection, $request->payment_type)->id;

        foreach($class->permissions as $action)
        {
            count($request->all()) >= 1 && $class->TraineeDataHelper($trainee, $request, $action, $class);
        }

        count($request->all()) >= 1 && $trainee->save();

        return $trainee;
    }
}
