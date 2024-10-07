<?php

namespace App\Trainees\Holdlist\Deletes;

use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Traits\BulkHelper;
use App\Permissions\Permissions;
use Exception;


class BulkDelete extends Permissions
{
    use BulkHelper;

    public function __construct()
    {
        $this->permission = 'deleteHoldTrainee';
    }

    public function delete(?Trainee $trainee, Request $request)
    {
        $this->Authorized($trainee, $request->trainees, $this);

        try 
        {
            foreach($request->trainees as $trainee_id)
            {
                $current_trainee = $trainee->find($trainee_id);
    
                $current_trainee->delete();
            }

            return response(['message' => "Trainees deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The trainees cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}