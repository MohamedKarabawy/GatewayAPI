<?php

namespace App\Trainees\Blacklist\Deletes;

use App\Models\Trainee;
use Illuminate\Support\Facades\Gate;
use App\Permissions\Permissions;
use Exception;

class Delete extends Permissions
{
    public function __construct(?Trainee $Trainee, $id)
    {
        Gate::authorize('deleteBlackTrainee', $Trainee->find($id));
    }

    public function delete(?Trainee $trainee, $id)
    {
        try 
        {
            $current_trainee = $trainee->find($id);
                
            $current_trainee->delete();

            return response(['message' => "Trainee deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Trainee cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}