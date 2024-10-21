<?php

namespace App\Trainees\Waitlist\Show;

use Exception;
use App\Models\Trainee;
use App\Models\ClassMeta;
use Illuminate\Support\Facades\Gate;

class ViewClassesLevels
{
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('assignClass', $trainee);
        
        $this->collection_key = 'levels';
    }

    public function viewClassesLevels(?ClassMeta $level)
    {
        try
        {
            $levels = $level->where('meta_key', $this->collection_key)->get();

            $levels_collection = [];

            foreach ($levels as $key => $g_level)
            {
                $levels_collection[$key] = [
                    'id' => $g_level->id,
                    'level_name' => $g_level->meta_value
                ];
            }

            
            return response($levels_collection, 200);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Levels cannot be viewed. Please contact the administrator of the website."], 400);
        }   
    }
}