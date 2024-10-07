<?php

namespace App\Branches;

use App\Models\Branch;
use App\Http\Requests\BranchRequest;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use Exception;

class Update extends Permissions
{
    public function __construct(?Branch $branch)
    {
        Gate::authorize('updateBranch', $branch);
    }

    public function update(?Branch $branch, BranchRequest $request, $id)
    {
        try
        {
            $current_branch = $branch->find($id);

            $current_branch->update(['country' => $request->country, 'city' => $request->city, 'district' => $request->district]);

            return response(['message' => "Branch updated successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The branch cannot be updated. Please contact the administrator of the website."], 400);
        }
    }
}
