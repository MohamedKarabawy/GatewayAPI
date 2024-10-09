<?php

namespace App\Trainees\Blacklist\Move;

use App\Models\Trainee;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use App\Trainees\Helpers\ListChangerHelper;
use App\Traits\GetList;
use Exception;

class BlackMoveToWait extends Permissions
{
    use ListChangerHelper, GetList;
    
    public function __construct(?Trainee $trainee, $id)
    {
        Gate::authorize('moveBlackToWait', $trainee->find($id));

        $this->list = 'Wait List';

        $this->list_name = 'wait list';
    }

    public function move(?Trainee $trainee, $id)
    {
        try
        {   
            $message = $this->listChanger($trainee->find($id), $this);
            
            return $message;
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The trainee cannot be moved. Please contact the administrator of the website."], 400);
        }
    }
}