<?php

namespace App\Batches;

use Carbon\Carbon;
use App\Models\Batch;
use Illuminate\Http\Request;
use App\Permissions\Permissions;

class Update extends Permissions
{
    public function __construct(?Batch $batch, $id)
    {
 
    }

    public function update(?Batch $batch, Request $request, $id)
    {
        try
        {
            boolval($request->status) === true && $batch->where('is_active', true)->update(['is_active' => false]);
            
            $batch->find($id)->update(['batch_title' => $request->batch_title, 'start_date' => Carbon::parse($request->start_date), 'end_date' => Carbon::parse($request->end_date), 'is_active' => boolval($request->status)]);
            
            return response(['message' => "Batch updated successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be updated. Please contact the administrator of the website."], 400);
        }
    }
}