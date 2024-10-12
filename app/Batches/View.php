<?php

namespace App\Batches;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Permissions\Permissions;
use App\Batches\Helpers\GetBatches;
use App\Traits\CheckPermissionStatus;
use App\Batches\Helpers\ViewBatchesHelper;
use App\Batches\Helpers\GetBatchesDataHelper;

class View extends Permissions
{
    use CheckPermissionStatus, GetBatches, GetBatchesDataHelper, ViewBatchesHelper;

    public function __construct($current_user)
    {
        $this->current_user = $current_user;
        
        $this->permission_collection = 'waitlist';
    }

    public function view(?Batch $batch)
    {
        try
        {    
            return $this->viewBatches($batch, $this);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. The batch cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}