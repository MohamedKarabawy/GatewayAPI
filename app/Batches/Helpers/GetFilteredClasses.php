<?php

namespace App\Batches\Helpers;

use App\Models\TraineeClass;

trait GetFilteredClasses
{
    protected function getCollection($class, $batch, $request, $batch_id, $this_class, $current_user = null)
    {
            $current_batch = $batch->where('id', $batch_id)->first();

            $classes = [];

            $filter_elements = ['class_type', 'level', 'time_slot', 'gate', 'trainer_id'];

            $classes = $class->where('batch_id', $current_batch?->id);

            $current_user !== null && $classes = $classes->where('user_id', $current_user->id);

            $current_classes = $classes;

            foreach($filter_elements as $filter_element)
            {
                $request->filled($filter_element) && $current_classes = $current_classes->where($filter_element, $request->$filter_element);
            }

            $classes = $current_classes->get();

            $classes_collection = [];

            foreach((object) $classes as $key => $t_class)
            {
                $classes_collection[$key] = [
                    'id' => $t_class?->id,
                    'trainer' => $this_class->User($t_class->user_id)->first()?->full_name,
                    'class_name' => $t_class?->class_name,
                    'class_type' => $t_class?->class_type,
                    'gate' => $this_class?->meta($t_class->gate)?->first()?->meta_value,
                    'time_slot' => $this_class->meta($t_class->time_slot)->first()?->meta_value,
                    'level' => $this_class->meta($t_class->level)->first()?->meta_value,
                    'num_of_trainees' => TraineeClass::where('class_id', $t_class->id)->count(),
                    'num_of_confirmation' => TraineeClass::where('class_id', $t_class->id)->where('confirmation', true)->count()
                ];
            }

            return $classes_collection;
    }
}