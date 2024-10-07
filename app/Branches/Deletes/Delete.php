<?php

namespace App\Branches\Deletes;

use App\Models\Branch;
use Illuminate\Support\Facades\Gate;
use Exception;

class Delete
{
    public function __construct(?Branch $branch)
    {
        Gate::authorize('deleteBranch', $branch);
    }

    public function delete(?Branch $branch, $id)
    {
        try
        {
            $current_branch = $branch->find($id);

            $current_branch->delete();

            return response(['message' => "Branch deleted successfully."], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. Branch cannot be deleted. Please contact the administrator of the website."], 400);
        }
    }
}