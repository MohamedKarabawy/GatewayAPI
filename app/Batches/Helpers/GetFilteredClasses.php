<?php

namespace App\Batches\Helpers;

trait GetFilteredClasses
{
    protected function getCollection($batch, $class, $request, $batch_id, $current_user = null)
    {
            $current_batch = $batch->where('id', $batch_id)->first();

            $classes = [];

            $filter_elements = ['class_name', 'class_type', 'level', 'time_slot', 'gate', 'trainer'];

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
                    'name' => $t_class?->class_name
                ];
            }

            return $classes_collection;
    }
}