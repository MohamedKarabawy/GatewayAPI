<?php

namespace App\Batches\Classes;

use Exception;
use App\Models\Classes;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;


class UpdatePaymentFees extends Permissions
{

    public function __construct(?Classes $class)
    {
        Gate::authorize('updateClasses', $class);
    }

    public function update(?Trainee $trainee, Request $request, $trainee_id)
    {
        // try
        // {   
            if(!$request->filled('payment'))
            {
                return response(['message' => "Payment/Fees field is required."], 400);
            }

            $trainee->where('id', $trainee_id)->update([
                'paid_value' => $request->payment
            ]);         
            
            return response(['message' => "Payment/Fees updated successfully."], 201);

        // }
        // catch (Exception $e)
        // {
        //     return response(['message' => "Something went wrong. Payment/Fees cannot be updated. Please contact the administrator of the website."], 400);
        // }
    }
}