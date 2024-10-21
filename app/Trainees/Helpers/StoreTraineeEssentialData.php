<?php

namespace App\Trainees\Helpers;

use Carbon\Carbon;

trait StoreTraineeEssentialData
{
    protected function StoreTraineeEssentialData($trainee, $request, $class)
    {
        count($request->all()) >= 2 && $trainee->current_list = $class->List($class->list)->id;

        count($request->all()) >= 2 && $trainee->user_id = $class->current_user->id;

        $request->has('branch') && $trainee->branch_id = $class->Branch($request->branch)->id;

        $request->has('full_name') && $trainee->full_name = $request->full_name;

        $request->has('notes') && $trainee->notes = $request->notes;

        $request->has('attend_type') && $trainee->attend_type = $request->attend_type;

        $request->has('payment_type') && $trainee->payment_type = $class->GetGeneralMeta($request->payment_type)->id;

        $request->has('level') && $trainee->level = $class->GetGeneralMeta($request->level)->id;

        $request->has('preferable_time') && $trainee->preferable_time = $class->GetGeneralMeta($request->preferable_time)->id;

        $request->has('sec_preferable_time') && $trainee->sec_preferable_time = $class->GetGeneralMeta($request->sec_preferable_time)->id;

        ($request->has('trainer') && $class->permission_collection === 'waitlist') && $trainee->trainer_id = $class->User($request->trainer)->id;

        ($request->has('follow_up') && $class->permission_collection === 'pendinglist') && $trainee->follow_up = $class->User($request->follow_up)->id;

        $request->has('test_date') && $trainee->test_date = Carbon::parse($request->test_date);

        count($request->all()) >= 2  && $trainee->moved_date = Carbon::now();

        count($request->all()) >= 2 && $trainee->save();

        return $trainee;
    }
}