<?php

namespace App\Branches;

use App\Models\Branch;
use App\Http\Requests\BranchRequest;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Gate;
use Exception;


class Create extends Permissions
{
    public function __construct(?Branch $branch)
    {
        Gate::authorize('createBranch', $branch);
    }

    public function create(?Branch $branch, BranchRequest $request)
    {
        try
        {
            $branch->create(['country' => $request->country, 'city' => $request->city, 'district' => $request->district]);

            return response(['message' => "Branch created successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The branch cannot be created. Please contact the administrator of the website."], 400);
        }
    }
}