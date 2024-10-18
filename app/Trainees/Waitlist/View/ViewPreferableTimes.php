<?php

namespace App\Trainees\Waitlist\View;

use App\Models\Trainee;
use App\Models\GeneralMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ViewPreferableTimes
{
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('viewTrainers', $trainee);

        $this->collection_key['online'] = 'preferable_times_online';

        $this->collection_key['offline'] = 'preferable_times_offline';

        $this->collection_key['hybird'] = 'preferable_times_hybird';
        
    }

    public function viewPreferableTimes(?GeneralMeta $preferable_time, Request $request)
    {
        try
        {
            if(!$request->filled('attend_type'))
            {
                return response(['message' => 'Attend type is required'], 500);   
            }

            switch($request->attend_type)
            {
                case 'online':
                    $attend_type = $this->collection_key['online'];
                    break;
                case 'offline':
                    $attend_type = $this->collection_key['offline'];
                    break;
                case 'hybrid':
                    $attend_type = $this->collection_key['hybird'];
                    break;
            }

            $preferable_times = $preferable_time->where('meta_key', $attend_type)->get();
            
            $preferable_times_collection = [];

            foreach ($preferable_times as $key => $g_preferable_time)
            {
                $preferable_times_collection[$key] = [
                    'id' => $g_preferable_time->id,
                    'preferable_time' => $g_preferable_time->meta_value
                ];
            }
            
            return response($preferable_times_collection, 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Preferable times cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}