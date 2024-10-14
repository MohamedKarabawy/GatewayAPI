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

        $this->list_name = 'preferable_times';
    }

    public function addPreferableTime(?GeneralMeta $preferable_time, Request $request)
    {
        try
        {
            $is_exists = $preferable_time->where('meta_key', $this->list_name)->where('meta_value', $request->preferable_time)->exists();
            
            if ($is_exists) 
            {
                return response(['message' => 'Payment type already exists'], 400);
            }
            
            $preferable_time->create([
                'meta_key' => $this->list_name,
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