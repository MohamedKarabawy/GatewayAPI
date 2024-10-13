<?php

namespace App\Batches\Classes;

use Exception;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Update extends Permissions
{
    public function __construct(?Classes $class, $current_user, $class_id)
    {
        Gate::authorize('updateClasses', $class->find($class_id));

        $this->current_user = $current_user;
    }

    public function update(?Classes $class, Request $request, $batch_id, $class_id)
    {
        try
        {            
            $current_class = $class->where('batch_id', $batch_id)->where('id', $class_id)->first();

            $request->has('trainer_id') && $current_class->trainer_id = $request->trainer_id;

            $request->has('class_name') && $current_class->class_name = $request->class_name;

            $request->has('class_type') && $current_class->class_type = $request->class_type;

            $request->has('gate_id') && $current_class->gate = $request->gate_id;

            $request->has('time_id') && $current_class->time_slot = $request->time_id;

            $request->has('level_id') && $current_class->level = $request->level_id;

            $request->all() >= 1 && $current_class->save();
            
            return response(['message' => "Class updated successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Class cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}