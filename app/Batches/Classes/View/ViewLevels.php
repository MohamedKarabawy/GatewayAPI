<?php

namespace App\Batches\Classes\View;

use App\Models\ClassMeta;
use App\Permissions\Permissions;

class ViewLevels extends Permissions
{
    public function __construct(?ClassMeta $level)
    {
        $this->collection_key = 'levels';
    }

    public function viewLevels(?ClassMeta $level)
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
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Levels cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}