<?php

namespace App\Batches\Classes\Add;

use Exception;
use App\Models\ClassMeta;
use Illuminate\Http\Request;
use App\Permissions\Permissions;

class TimeSlot extends Permissions
{
    public function __construct(?ClassMeta $time_slots)
    {
        $this->collection_key = 'time_slots';
    }

    public function add(?ClassMeta $time_slot, Request $request)
    {
        try
        {
            $time_slot->create(['meta_key' => $this->collection_key, 'meta_value' => $request->time_slot]);
            
            return response(['message' => "Time Slot added successfully."], 201);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Time Slot cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}