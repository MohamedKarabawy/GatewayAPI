<?php

namespace App\Batches\Classes;

use Exception;
use App\Models\Classes;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Delete extends Permissions
{
    public function __construct(?Classes $class, $class_id)
    {
        Gate::authorize('deleteClasses', $class->find($class_id));
    }

    public function delete(?Classes $class, $batch_id, $class_id)
    {
        try
        {
            $current_class = $class->where('batch_id', $batch_id)->where('id', $class_id)->first();

            $current_class->delete();
            
            return response(['message' => "Class deleted successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Class cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}