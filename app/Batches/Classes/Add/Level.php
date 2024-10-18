<?php

namespace App\Batches\Classes\Add;

use Exception;
use App\Models\Classes;
use App\Models\ClassMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Level extends Permissions
{
    public function __construct(?Classes $class)
    {
        Gate::authorize('authComponents', $class);

        $this->collection_key = 'levels';
    }

    public function add(?ClassMeta $level, Request $request)
    {
        try
        {
            $current_position = $level->select('id')->max('position');

            $current_position === null && $current_position = 0;

            $level->create(['meta_key' => $this->collection_key, 'meta_value' => $request->level, 'position' => $current_position + 1]);
            
            return response(['message' => "Level added successfully."], 201);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Level cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}