<?php

namespace App\Batches\Action;

use App\Models\Batch;
use App\Permissions\Permissions;

class ActivateBatch extends Permissions
{
    public function __construct(?Batch $batch, $id)
    {

    }

    public function activateBatch(?Batch $batch, $id)
    {
        try
        {
            $batch->where('is_active', true)->update(['is_active' => false]);
            
            $batch->where('id', $id)->update(['is_active' => true]);
                        
            return response(['message' => "Batch activated successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be activated. Please contact the administrator of the website."], 400);
        }
    }
}