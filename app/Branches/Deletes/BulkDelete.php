<?php

namespace App\Branches\Deletes;

use App\Models\Branch;
use App\Http\Requests\BulkBranchRequest;
use App\Traits\BulkHelper;
use Exception;

class BulkDelete
{
    use BulkHelper;

    public function __construct()
    {
        $this->permission = 'deleteBranch';
    }

    public function delete(?Branch $branch, BulkBranchRequest $request)
    {
        $this->Authorized($branch, $request->branches, $this);

        try
        {
            foreach($request->branches as $branch_id)
            {
                $current_branch = $branch->find($branch_id);

                $current_branch->delete();
            }

            return response(['message' => "Branches deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The branches cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}
