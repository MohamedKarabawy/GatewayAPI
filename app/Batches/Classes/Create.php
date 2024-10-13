<?php

namespace App\Batches\Classes;

use Exception;
use App\Models\User;
use App\Models\Classes;
use App\Models\ClassMeta;
use Illuminate\Http\Request;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use App\Batches\Helpers\GetBatchesDataHelper;

class Create extends Permissions
{
    use GetBatchesDataHelper;

    public function __construct(?Classes $class, $current_user)
    {
        Gate::authorize('createClasses', $class);

        $this->current_user = $current_user;
    }

    public function create(?Classes $class, ?User $user, ?ClassMeta $class_meta, Request $request, $batch_id)
    {
        try
        {   
            $trainer = $user->find($request->trainer_id)->first()->full_name; 

            $gate = $this->getData($class_meta, $request->gate_id);
            
            $time_slot = $this->getData($class_meta, $request->time_id);

            $level = $this->getData($class_meta, $request->level_id); 

            $class->create([
                'user_id' => $this->current_user->id, 
                'batch_id' => $batch_id, 
                'trainer_id' => $request->trainer_id, 
                'class_name' => $request->class_type.' - '.$gate.' - '.$time_slot.' - '.$trainer.' - '.$level, 
                'class_type' => $request->class_type,
                'gate' => $request->gate_id,
                'time_slot' => $request->time_id,
                'level' => $request->level_id]);
            
            return response(['message' => "Class created successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Class cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}