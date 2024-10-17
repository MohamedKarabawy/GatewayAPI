<?php

namespace App\Trainees\WaitList\Show;

use Exception;
use App\Models\Batch;
use App\Models\Classes;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ViewClasses
{
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('assignClass', $trainee);
    }

    public function viewClasses(?Classes $class, ?Batch $batch, Request $request)
    {
        try
        {
            $current_batch = $batch->where('is_active', true)->first();

            $classes = [];

            $classes = $class?->where('batch_id', $current_batch?->id)?->get();

            ($request->filled('class_type') && $request->filled('level_id') && $request->filled('time_id')) && $classes = $class->where('batch_id', $current_batch->id)->where('class_type', $request->class_type)->where('level', $request->level_id)->where('time_slot', $request->time_id)->get();
        
            ($request->filled('class_type') && $request->filled('time_id') && (count($request->all()) === 2)) && $classes = $class->where('batch_id', $current_batch->id)->where('class_type', $request->class_type)->where('time_slot', $request->time_id)->get();

            ($request->filled('class_type') && $request->filled('level_id') && (count($request->all()) === 2)) && $classes = $class->where('batch_id', $current_batch->id)->where('class_type', $request->class_type)->where('level', $request->level_id)->get();
            
            ($request->filled('level_id') && $request->filled('time_id') && (count($request->all()) === 2)) && $classes = $class->where('batch_id', $current_batch->id)->where('level', $request->level_id)->where('time_slot', $request->time_id)->get();
            
            ($request->filled('class_type') && count($request->all()) === 1) && $classes = $class->where('batch_id', $current_batch->id)->where('class_type', $request->class_type)->get();

            ($request->filled('level_id') && count($request->all()) === 1) && $classes = $class->where('batch_id', $current_batch->id)->where('level', $request->level_id)->get();
            
            ($request->filled('time_id') && count($request->all()) === 1) && $classes = $class->where('batch_id', $current_batch->id)->where('time_slot', $request->time_id)->get();
    

            $classes_collection = [];

            foreach((object) $classes as $key => $t_class)
            {
                $classes_collection[$key] = [
                    'id' => $t_class?->id,
                    'name' => $t_class?->class_name
                ];
            }
            
            return response($classes_collection, 200);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Classes cannot be viewed. Please contact the administrator of the website."], 400);
        }   
    }
}