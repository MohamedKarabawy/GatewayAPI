<?php

namespace App\Batches;

use App\Models\Batch;
use App\Models\TraineeClass;
use Illuminate\Http\Request;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;

class Duplicate extends Permissions
{
    public function __construct(?Batch $batch)
    {
        Gate::authorize('createBatches', $batch);
    }

    public function duplicate(?Batch $batch, TraineeClass $trainee_class)
    {
        try
        {
            $current_batch = $batch->where('is_active', true);

            $originalBatch = $current_batch->first();

            $current_batch->update(['is_active' => false]);
            
            $duplicateBatch = $originalBatch->replicate();

            $duplicateBatch->batch_title = "Copy of ". $originalBatch->batch_title;

            $duplicateBatch->save();

            $originalBatch = $batch->where('id', $originalBatch->id)->first();
            
            foreach ($originalBatch->classes as $class)
            {
                $duplicateClass = $class->replicate();

                $duplicateClass->batch_id = $duplicateBatch->id;
                
                $duplicateClass->save();
                
                $trainee_classes = $trainee_class->where('class_id', $class->id)->get();

                $duplicate_trainee_class = $trainee_class;

                

                foreach ($trainee_classes as $t_class)
                {
                    var_dump($t_class);
                    $duplicate_trainee_class->class_id = $duplicateClass->id;

                    $duplicate_trainee_class->trainee_id = $t_class->trainee_id;

                    $duplicate_trainee_class->confirmation = $t_class->confirmation;

                    $duplicate_trainee_class->save();
                }
            }

            
            return response(['message' => "Batch duplicated successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be duplicated. Please contact the administrator of the website."], 400);
        }
    }
}