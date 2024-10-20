<?php

namespace App\Trainees\Waitlist\Show;

use Exception;
use App\Models\Trainee;
use App\Models\ClassMeta;
use Illuminate\Support\Facades\Gate;

class ViewClassesTime
{
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('assignClass', $trainee);

        $this->collection_key['online'] = 'preferable_times_online';

        $this->collection_key['offline'] = 'preferable_times_offline';

        $this->collection_key['hybird'] = 'preferable_times_hybird';
    }

    public function viewClassesTime(?ClassMeta $time_slot, Request $request)
    {
        try
        {
            if(!$request->filled('attend_type'))
            {
                return response(['message' => 'Attend type is required'], 400);   
            }

            $attend_type = '';

            switch($request->attend_type)
            {
                case 'Online':
                    $attend_type = $this->collection_key['online'];
                    break;
                case 'Offline':
                    $attend_type = $this->collection_key['offline'];
                    break;
                case 'Hybrid':
                    $attend_type = $this->collection_key['hybird'];
                    break;
            }

            $time_slots = $time_slot->where('meta_key', $attend_type)->get();

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
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Time Slots cannot be viewed. Please contact the administrator of the website."], 400);
        }   
    }
}