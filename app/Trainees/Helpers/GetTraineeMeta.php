<?php

namespace App\Trainees\Helpers;

use Carbon\Carbon;

trait GetTraineeMeta
{
    protected function getCollection($trainees, $class)
    {
        $collection = [];

        $collection_index = 0;

        foreach((object) $trainees as $key => $trainee)
        {
            $trainer_collection = [];

            $level_collection = [];

            $follow_up_collection = [];

            $meta_collection = [];

            $trainee_collection = [];

            $sub_collection = [];

            $phone_index = 0;

            if($trainee?->list?->list_title === $class?->list)
            {
                foreach($class->keys as $col_key)
                {
                    $trainee_collection[$col_key] = $trainee->$col_key;
                }

                $sub_collection = ['branch' => $trainee?->branch?->district, "payment_type" => $class?->GetGeneralMeta($trainee?->payment_type)?->meta_value, "preferable_time" => $class?->GetGeneralMeta($trainee?->preferable_time)?->meta_value];

                foreach($trainee->trainee_meta as $meta)
                {
                    $meta_collection[$meta->meta_key] = $meta->meta_value;
                }

                $class->isAllowed($class->current_user, 'view_trainers', $class->permission_collection, $trainee?->user_id) && $trainer_collection = ['trainer' => $class->User($trainee->trainer_id)?->full_name];

                $class->isAllowed($class->current_user, 'view_own_trainers', $class->permission_collection, $trainee?->user_id) && $trainer_collection = ['trainer' => $class->User($trainee->trainer_id)?->full_name];

                $class->isAllowed($class->current_user, 'view_levels', $class->permission_collection, $trainee?->user_id) && $level_collection = ['level' => $class?->GetGeneralMeta($trainee?->level)?->meta_value];

                $class->isAllowed($class->current_user, 'view_own_levels', $class->permission_collection, $trainee?->user_id) && $level_collection = ['level' => $class?->GetGeneralMeta($trainee?->level)?->meta_value];

                $class->isAllowed($class->current_user, 'view_follow_up', $class->permission_collection, $trainee?->user_id) && $follow_up_collection = ['follow_up' => $class->User($trainee->follow_up)?->full_name];

                $class->isAllowed($class->current_user, 'view_own_follow_up', $class->permission_collection, $trainee?->user_id) && $follow_up_collection = ['follow_up' => $class->User($trainee->follow_up)?->full_name];
                
                $collection[$collection_index++] = [...$trainee_collection, ...$sub_collection, ...$trainer_collection, ...$level_collection, ...$follow_up_collection, ...$meta_collection, 'test_date' => $trainee?->test_date, 'moved_date' => Carbon::parse($trainee?->moved_date)->format("m/d/Y"),'created_at' => $trainee?->created_at, 'updated_at' => $trainee?->updated_at];
            }
        }

        return $collection;
    }
}