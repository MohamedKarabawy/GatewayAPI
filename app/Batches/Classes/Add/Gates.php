<?php

namespace App\Batches\Classes\Add;

use Exception;
use App\Models\Classes;
use App\Models\ClassMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class Gates extends Permissions
{
    public function __construct(?Classes $class)
    {
        Gate::authorize('authComponents', $class);

        $this->collection_key = 'gates';
    }

    public function add(?ClassMeta $gate, Request $request)
    {
        try
        {
            $gate->create(['meta_key' => $this->collection_key, 'meta_value' => $request->gate]);
            
            return response(['message' => "Gate added successfully."], 201);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Gate cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}