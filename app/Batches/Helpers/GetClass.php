<?php

namespace App\Batches\Helpers;

use App\Models\Attendance;

trait GetClass
{
    protected function getCollection($current_class, $trainee_class, $this_class)
    {
        $trainees_meta = $trainee_class->where('class_id', $current_class?->id)?->get();
        
        $trainees_collection = [];

        $meta_collection = [];

        foreach((object) $trainees_meta as $key => $meta)
        {
            foreach($meta?->trainees as $trainee)
            {   
                foreach($trainee->trainee_meta as $t_meta)
                {
                    str_contains($t_meta->meta_key, 'phone_number') && $meta_collection[$t_meta->meta_key] = $t_meta->meta_value;
                }
                
                $trainees_collection[$key] = [
                    'id' => $trainee?->id,
                    'status' => $this_class->status($trainee->id) > 1 ? 'Current Test' : 'New Test',
                    'full_name' => $trainee?->full_name,
                    ...$meta_collection,
                    'payment' => $this_class?->meta($trainee, 'paid_value')?->meta_value,
                    'confirmation' => $this_class?->meta($trainee, 'confirmation')?->meta_value,
                    'trainer_note' => Attendance::where('class_id', $current_class?->id)->where('trainee_id', $trainee?->id)->first()->trainer_note,
                    'admin_note' => Attendance::where('class_id', $current_class?->id)->where('trainee_id', $trainee?->id)->first()->admin_note,
                ];
            }
        }

            

        
        return $trainees_collection;
    }
}