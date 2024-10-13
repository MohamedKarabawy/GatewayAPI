<?php

namespace App\Batches;

use Exception;
use Carbon\Carbon;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Create extends Permissions
{
    public function __construct(?Batch $batch, $current_user)
    {
        Gate::authorize('createBatches', $batch);
        
        $this->current_user = $current_user;
    }

    public function create(?Batch $batch, Request $request)
    {
        try
        {
            boolval($request->status) === true && $batch->where('is_active', true)->update(['is_active' => false]);
            
            $batch->create(['user_id' => $this->current_user->id, 'batch_title' => $request->batch_title, 'start_date' => Carbon::parse($request->start_date), 'end_date' => Carbon::parse($request->end_date), 'is_active' => boolval($request->status)]);
            
            return response(['message' => "Batch created successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}