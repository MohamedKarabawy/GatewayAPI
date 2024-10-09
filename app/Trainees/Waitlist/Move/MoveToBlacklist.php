<?php

namespace App\Trainees\Waitlist\Move;

use Exception;
use App\Models\Trainee;
use App\Traits\GetList;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use App\Trainees\Helpers\ListChangerHelper;

class MoveToBlacklist extends Permissions
{
    use ListChangerHelper, GetList;
    
    public function __construct(?Trainee $trainee, $id)
    {
        Gate::authorize('moveWaitToBlack', $trainee->find($id));

        $this->list = 'Blacklist';
        
        $this->list_name = 'blacklist';
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