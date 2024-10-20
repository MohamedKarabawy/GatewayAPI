<?php

namespace App\Batches\Classes\Add;

use Exception;
use App\Models\Classes;
use App\Models\ClassMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;

class TimeSlot extends Permissions
{
    public function __construct(?Classes $class)
    {
        Gate::authorize('authComponents', $class);
        
        $this->collection_key['Online'] = 'time_slots_online';

        $this->collection_key['Offline'] = 'time_slots_offline';

        $this->collection_key['Hybird'] = 'time_slots_hybrid';
    }

    public function add(?ClassMeta $time_slot, Request $request)
    {
        try
        {
            $request->filled('attend_type') && $is_exists = $time_slot->where('meta_key', $this->collection_key[$request->attend_type])->where('meta_value', $request->time_slot)->exists();


            if ($is_exists || !$request->filled('attend_type')) 
            {
                return response(['message' => 'Time Slot already exists or attend type not set.'], 400);
            }

            $attend_type = '';

            switch($request->attend_type)
            {
                case 'Online':
                    $attend_type = $this->collection_key['Online'];
                    break;
                case 'Offline':
                    $attend_type = $this->collection_key['Offline'];
                    break;
                case 'Hybrid':
                    $attend_type = $this->collection_key['Hybird'];
                    break;
            }

            $time_slot->create(['meta_key' => $attend_type, 'meta_value' => $request->time_slot]);
            
            return response(['message' => "Time Slot added successfully."], 201);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Time Slot cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}