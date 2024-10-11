<?php

namespace App\Batches\Classes\Add;

use Exception;
use App\Models\ClassMeta;
use Illuminate\Http\Request;
use App\Permissions\Permissions;

class Gate extends Permissions
{
    public function __construct(?ClassMeta $gate)
    {
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