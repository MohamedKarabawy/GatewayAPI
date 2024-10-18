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

        $this->list_name['hybird'] = 'preferable_times_hybrid';
    }

    public function addPreferableTime(?GeneralMeta $preferable_time, Request $request)
    {
        try
        {
            $is_exists_online = $preferable_time->where('meta_key', $this->list_name['online'])->where('meta_value', $request->preferable_time)->exists();

            $is_exists_offline = $preferable_time->where('meta_key', $this->list_name['offline'])->where('meta_value', $request->preferable_time)->exists();

            $is_exists_hybird = $preferable_time->where('meta_key', $this->list_name['hybird'])->where('meta_value', $request->preferable_time)->exists();

            
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
            
            $preferable_time->create([
                'meta_key' => $attend_type, 
                'meta_value' => $request->preferable_time,
            ]);

            return response(['message' => 'Preferable time added successfully'], 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Payment type cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}