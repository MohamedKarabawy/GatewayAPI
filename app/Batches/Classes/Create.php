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
            $trainer = $user->where('id', $request->trainer_id)->first()->full_name; 

            $gate = $this->getData($class_meta, $request->gate_id);
            
            $time_slot = $this->getData($class_meta, $request->time_id);

            $level = $this->getData($class_meta, $request->level_id); 

            $current_class = $class;
            
            $current_class->user_id = $this->current_user->id;

            $current_class->batch_id = $batch_id;
            
            $current_class->trainer_id = $request->trainer_id;
            
            $current_class->class_name = $request->class_type.' - '.$gate.' - '.$time_slot.' - '.$trainer.' - '.$level;
            
            $current_class->class_type = $request->class_type;

            $current_class->gate = $request->gate_id;

            $current_class->time_slot = $request->time_id;
            
            $current_class->level = $request->level_id;

            $request->class_type === 'Online' &&  $current_class->gate_url = $request->gate_url;

            $request->class_type === 'Online' && $current_class->gate_password = $request->gate_password;

            $current_class->save();
            
            return response(['message' => "Class created successfully."], 201);

        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Class cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}