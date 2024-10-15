<?php

namespace App\Trainees\Pendinglist\Assign;

use Exception;
use App\Models\User;
use App\Models\Trainee;
use Illuminate\Http\Request;

class AssignTrainer
{
    public function __construct(?Trainee $trainee, $trainee_id)
    {
        Gate::authorize('assignTrainer', $trainee->find($trainee_id));
    }

    public function assign(?Trainee $trainee, ?User $trainer, Request $request, $trainee_id)
    {
        try
        {
            $is_exists = $users->where('id', $request->trainer)->exists();

            if (!$is_exists)
            {
                return response(['message' => 'Trainer is not exists in the system.'], 400);
            }

            $trainee->where('id', $trainee_id)->update([
                'trainer_id' => $request->trainer
            ]);
            
            return response(['message' => 'Trainer assigned successfully'], 200);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Trainer cannot be assigned. Please contact the administrator of the website."], 400);
        }
    }
}