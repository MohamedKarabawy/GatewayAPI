<?php

namespace App\Batches\Helpers;

trait GetAttendance
{
    protected function getCollection($attendances, $class)
    {        
        $trainees_collection = [];

        $meta_collection = [];

       

        foreach((object) $attendances as $key => $meta)
        {

            foreach($meta?->trainees as $trainee)
            {   
                foreach($trainee->trainee_meta as $t_meta)
                {
                    str_contains($t_meta->meta_key, 'phone_number') && $meta_collection[$t_meta->meta_key] = $t_meta->meta_value;
                }
                
                $trainees_collection[$key] = [
                    'id' => $trainee?->id,
                    'full_name' => $trainee?->full_name,
                    ...$meta_collection,
                    'trainer_note' => $meta->trainer_note,
                    'admin_note' => $meta->admin_note,
                ];
            }
        }

        return $trainees_collection;
    }
}