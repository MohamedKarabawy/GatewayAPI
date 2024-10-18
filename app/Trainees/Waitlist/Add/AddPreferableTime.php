<?php

namespace App\Trainees\Waitlist\Add;

use Exception;
use App\Models\Trainee;
use App\Models\GeneralMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddPreferableTime
{
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('viewTrainers', $trainee);

        $this->list_name['online'] = 'preferable_times_online';

        $this->list_name['offline'] = 'preferable_times_offline';
    }

    public function addPreferableTime(?GeneralMeta $preferable_time, Request $request)
    {
        try
        {
            $is_exists_online = $preferable_time->where('meta_key', $this->list_name['online'])->where('meta_value', $request->preferable_time)->exists();

            $is_exists_offline = $preferable_time->where('meta_key', $this->list_name['offline'])->where('meta_value', $request->preferable_time)->exists();

            
            if ($is_exists_online || $is_exists_offline) 
            {
                return response(['message' => 'Payment type already exists'], 400);
            }
            
            $preferable_time->create([
                'meta_key' => $request->attend_type === 'Online' ?  $this->list_name['online'] :  $this->list_name['offline'],
                'meta_value' => $request->preferable_time,
            ]);

            return response(['message' => 'Payment type added successfully'], 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Payment type cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}