<?php

namespace App\Batches\Classes\Add;

use Exception;
use App\Models\ClassMeta;
use Illuminate\Http\Request;
use App\Permissions\Permissions;

class Level extends Permissions
{
    public function __construct(?ClassMeta $level)
    {
        $this->collection_key = 'levels';
    }

    public function add(?ClassMeta $level, Request $request)
    {
        try
        {
            $level->create(['meta_key' => $this->collection_key, 'meta_value' => $request->level]);
            
            return response(['message' => "Level added successfully."], 201);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Level cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}