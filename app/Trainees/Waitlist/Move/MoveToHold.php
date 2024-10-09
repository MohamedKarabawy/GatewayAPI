<?php

namespace App\Trainees\Waitlist\Move;

use App\Models\Trainee;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use App\Trainees\Helpers\ListChangerHelper;
use App\Traits\GetList;
use Exception;

class MoveToHold extends Permissions
{
    use ListChangerHelper, GetList;
    
    public function __construct(?Trainee $trainee, $id)
    {
        Gate::authorize('moveWaitToHold', $trainee->find($id));

        $this->list = 'Hold List';

        $this->list_name = 'hold list';
    }

    public function move(?Trainee $trainee, $id)
    {
        try
        {   
            $message = $this->listChanger($trainee->find($id), $this, $id);
            
            return $message;
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The trainee cannot be moved. Please contact the administrator of the website."], 400);
        }
    }
}