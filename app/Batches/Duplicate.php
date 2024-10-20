<?php

namespace App\Batches;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Update extends Permissions
{
    public function __construct(?Batch $batch, $id)
    {
        Gate::authorize('updateBatches', $batch->find($id));
    }

    public function update(?Batch $batch)
    {
        try
        {
            $current_batch = $batch->where('is_active', true);

            $originalBatch = $current_batch->first();

            boolval($request->status) === true && $current_batch->update(['is_active' => false]);
            
            $duplicateBatch = $originalBatch->replicate();
            
            return response(['message' => "Batch duplicated successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be duplicated. Please contact the administrator of the website."], 400);
        }
    }
}