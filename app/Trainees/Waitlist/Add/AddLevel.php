<?php

namespace App\Trainees\Waitlist\Add;

use Exception;
use App\Models\Trainee;
use App\Models\GeneralMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddLevel
{
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('viewTrainers', $trainee);
        
        $this->list_name = 'waitlist_levels';
    }

    public function addLevel(?GeneralMeta $level, Request $request)
    {
        try
        {
            $is_exists = $level->where('meta_key', $this->list_name)->where('meta_value', $request->level)->exists();
            
            if ($is_exists) 
            {
                return response(['message' => 'Level already exists'], 400);
            }
            
            $level->create([
                'meta_key' => $this->list_name,
                'meta_value' => $request->level,
            ]);

            return response(['message' => 'Level added successfully'], 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Level cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}