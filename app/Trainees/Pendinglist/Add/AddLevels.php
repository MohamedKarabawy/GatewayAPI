<?php

namespace App\Trainees\Pendinglist\Add;

use Exception;
use App\Models\GeneralMeta;
use Illuminate\Http\Request;

class AddLevel
{
    public function __construct()
    {
        $this->list_name = 'pendinglist_levels';
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