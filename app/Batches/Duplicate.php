<?php

namespace App\Batches;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Duplicate extends Permissions
{
    public function __construct(?Batch $batch)
    {
        Gate::authorize('createBatches', $batch);
    }

    public function duplicate(?Batch $batch)
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
            }


            
            return response(['message' => "Batch duplicated successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be duplicated. Please contact the administrator of the website."], 400);
        }
    }
}