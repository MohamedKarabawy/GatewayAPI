<?php

namespace App\Trainees\Refundlist\Move\Bulk;

use Exception;
use App\Models\Trainee;
use App\Traits\GetList;
use App\Traits\BulkHelper;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use App\Trainees\Helpers\ListChangerHelper;

class RefundToWait extends Permissions
{
    use ListChangerHelper, GetList, BulkHelper;
    
    public function __construct($current_user)
    {
        $this->current_user = $current_user;

        $this->list = 'Wait List';

        $this->list_name = 'wait list';

        $this->permission = 'moveRefundToWait';
    }

    public function move(?Trainee $trainee, $request)
    {
        try
        {   
            $this->Authorized($trainee, $request->trainees, $this);
            
            foreach($request->trainees as $trainee_id)
            {
                $this->listChanger($trainee->find($trainee_id), $this);
            }
            
            return response(['message' => "Trainees move to ".$this->list_name." Successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The trainee cannot be moved. Please contact the administrator of the website."], 400);
        }
    }
}