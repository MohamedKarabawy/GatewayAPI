<?php

namespace App\Batches\Action;

use App\Models\Batch;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class EndBatch extends Permissions
{
    public function __construct(?Batch $batch, $id)
    {
        Gate::authorize('endBatch', $batch->find($id));
    }

    public function endBatch(?Batch $batch, $id)
    {
        try
        {
            $batch->where('id', $id)->update(['is_active' => false]);
                        
            return response(['message' => "Batch ended successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be ended. Please contact the administrator of the website."], 400);
        }
    }
}