<?php

namespace App\Batches\Classes\View;

use App\Models\ClassMeta;
use App\Permissions\Permissions;

class ViewTimeSlots extends Permissions
{
    public function __construct(?ClassMeta $time_slot)
    {
        $this->collection_key = 'time_slots';
    }

    public function viewTimeSlots(?ClassMeta $time_slot)
    {
        try
        {    
            $time_slots = $time_slot->where('meta_key', $this->collection_key)->get();

            $time_slots_collection = [];

            foreach ($time_slots as $key => $g_time_slot)
            {
                $time_slots_collection[$key] = [
                    'id' => $g_time_slot->id,
                    'time_slot' => $g_time_slot->meta_value
                ];
            }

            return response($time_slots_collection, 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Time Slots cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}