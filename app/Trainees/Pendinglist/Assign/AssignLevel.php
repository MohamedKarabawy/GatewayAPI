<?php

namespace App\Trainees\Pendinglist\Assign;

use Exception;
use App\Models\Trainee;
use App\Models\GeneralMeta;
use Illuminate\Http\Request;

class AssignLevel
{
    public function __construct()
    {
        $this->list_name = 'pendinglist_levels';
    }

    public function assign(?Trainee $trainee, ?GeneralMeta $level, Request $request, $trainee_id)
    {
        try
        {
            $is_exists = $level->where('meta_key', $this->list_name)->where('meta_value', $request->level)->exists();

            if (!$is_exists)
            {
                return response(['message' => 'Level is not exists in the pending list'], 400);
            }

            $trainee->where('id', $trainee_id)->update([
                'level' => $request->level 
            ]);
            
            return response(['message' => 'Level assigned successfully'], 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Level cannot be assigned. Please contact the administrator of the website."], 400);
        }
    }
}