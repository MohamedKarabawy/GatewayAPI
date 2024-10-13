<?php

namespace App\Batches\Action;

use Exception;
use App\Models\Batch;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Delete extends Permissions
{
    public function __construct(?Batch $batch, $id)
    {
        Gate::authorize('deleteBatches', $batch->find($id));
    }

    public function delete(?Batch $batch, $id)
    {
        try
        {
            $current_batch = $batch->find($id);

            $current_batch->delete();
            
            return response(['message' => "Batch deleted successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}