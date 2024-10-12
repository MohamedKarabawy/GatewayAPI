<?php

namespace App\Batches\Helpers;

use Carbon\Carbon;

trait GetBatches
{
    protected function getCollection($batches, $class)
    {
        $batches_collection = [];
        
        $data = [];

        $active_index = 0;

        $archive_index = 0;
        
        foreach($batches as $g_batch)
        {
            $batches_collection = [
                'id' => $g_batch->id,
                'batch_title' => $g_batch->batch_title,
                'start_date' => Carbon::parse($g_batch->start_date)->format('Y-m-d'),
                'end_date' => Carbon::parse($g_batch->end_date)->format('Y-m-d'),
                'status' => boolval($g_batch->is_active),
                'num_classes' => count($g_batch->classes)
            ];

            boolval($g_batch->is_active) === true ? $data['active'][$active_index++] = $batches_collection : $data['archive'][$archive_index++] = $batches_collection;
        }
        
        return $data;
    }
}