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
        
        $this->collection_key['online'] = 'time_slots_online';

        $this->collection_key['offline'] = 'time_slots_offline';

        $this->collection_key['hybird'] = 'time_slots_hybrid';
    }

    public function add(?ClassMeta $time_slot, Request $request)
    {
        try
        {
            $request->filled('attend_type') && $is_exists_online = $preferable_time->where('meta_key', $this->collection_key['online'])->where('meta_value', $request->preferable_time)->exists();

            $request->filled('attend_type') && $is_exists_offline = $preferable_time->where('meta_key', $this->collection_key['offline'])->where('meta_value', $request->preferable_time)->exists();

            $request->filled('attend_type') &&  $is_exists_hybird = $preferable_time->where('meta_key', $this->collection_key['hybird'])->where('meta_value', $request->preferable_time)->exists();

            if ($is_exists_online || $is_exists_offline || $is_exists_hybird || !$request->filled('attend_type')) 
            {
                return response(['message' => 'Preferable time already exists or attend type not set.'], 400);
            }

            $attend_type = '';

            switch($request->attend_type)
            {
                case 'Online':
                    $attend_type = $this->list_name['online'];
                    break;
                case 'Offline':
                    $attend_type = $this->list_name['offline'];
                    break;
                case 'Hybrid':
                    $attend_type = $this->list_name['hybird'];
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