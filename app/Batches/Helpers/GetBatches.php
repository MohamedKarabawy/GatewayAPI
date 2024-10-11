<?php

namespace App\Batches\Helpers;

use Carbon\Carbon;

trait GetBatches
{
    protected function getCollection($batches, $class)
    {
        $batches_collection = [];
            
        foreach($batches as $key => $g_batch)
        {
            $batches_collection[$key] = [
                'id' => $g_batch->id,
                'batch_title' => $g_batch->batch_title,
                'start_date' => Carbon::parse($g_batch->start_date)->format('Y-m-d'),
                'end_date' => Carbon::parse($g_batch->end_date)->format('Y-m-d'),
                'num_classes' => count($g_batch->classes)
            ];
        }
        
        return $batches_collection;
    }
}