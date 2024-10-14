<?php

namespace App\Trainees\Waitlist\Add;

use Exception;
use App\Models\Trainee;
use App\Models\GeneralMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddPaymentType
{
    public function __construct(?Trainee $trainee)
    {
        Gate::authorize('viewTrainers', $trainee);
        
        $this->list_name = 'payment_types';
    }

    public function addPaymentType(?GeneralMeta $payment_type, Request $request)
    {
        try
        {
            $is_exists = $payment_type->where('meta_key', $this->list_name)->where('meta_value', $request->payment_type)->exists();
            
            if ($is_exists) 
            {
                return response(['message' => 'Payment type already exists'], 400);
            }
            
            $payment_type->create([
                'meta_key' => $this->list_name,
                'meta_value' => $request->payment_type,
            ]);

            return response(['message' => 'Payment type added successfully'], 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Payment type cannot be added. Please contact the administrator of the website."], 400);
        }
    }
}