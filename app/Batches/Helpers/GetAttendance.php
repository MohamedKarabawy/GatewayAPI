<?php

namespace App\Batches\Helpers;

trait GetAttendance
{
    protected function getCollection($attendances, $class_id, $class)
    {        
        $trainees_collection = [];

        $meta_collection = [];

        $current_class = $class->getClass($class_id);

        $class_collection = [];

        $collection = [];

        foreach((object) $attendances as $key => $meta)
        {

            foreach($meta?->trainees as $trainee)
            {   
                foreach($trainee->trainee_meta as $t_meta)
                {
                    str_contains($t_meta->meta_key, 'phone_number') && $meta_collection[$t_meta->meta_key] = $t_meta->meta_value;
                }
                
                $trainees_collection['trainees'][$key] = [
                    'id' => $trainee?->id,
                    'full_name' => $trainee?->full_name,
                    ...$meta_collection,
                    'trainer_note' => $meta->trainer_note,
                    'admin_note' => $meta->admin_note,
                ];
            }
        }

        $current_class->class_type === 'Online' && $class_collection = [
            'gate_url' => $current_class->gate_url,
            'gate_password' => $current_class->gate_password
        ];

        $collection = [...$class_collection, ...$trainees_collection];

        return $collection;
    }
}