<?php

namespace App\Trainees\Helpers;

use Carbon\Carbon;

trait UpdateTraineeEssentialData
{
    protected function UpdateTraineeEssentialData($trainee, $request, $class)
    {
        $request->has('branch') && $trainee->branch_id = $class->Branch($request->branch)->id;

        $request->has('full_name') && $trainee->full_name = $request->full_name;

        $request->has('notes') && $trainee->notes = $request->notes;

        $request->has('attend_type') && $trainee->attend_type = $request->attend_type;

        $request->has('payment_type') && $trainee->payment_type = $class->GetGeneralMeta($request->payment_type)->id;

        $request->has('level') && $trainee->level = $class->GetGeneralMeta($request->level)->id;

        $request->has('preferable_time') && $trainee->preferable_time = $class->GetGeneralMeta($request->preferable_time)->id;

        ($request->has('trainer') && $class->permission_collection === 'waitlist') && $trainee->trainer_id = $class->User($request->trainer)->id;

        ($request->has('follow_up') && $class->permission_collection === 'pendinglist') && $trainee->follow_up = $class->User($request->follow_up)->id;

        $request->has('test_date') && $trainee->test_date = Carbon::parse($request->test_date);

        count($request->all()) >= 1 && $trainee->save();

        return $trainee;
    }
}