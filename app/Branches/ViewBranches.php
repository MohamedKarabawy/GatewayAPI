<?php

namespace App\Branches;

use App\Models\Branch;
use Exception;
use Auth;

class ViewBranches
{
    use GetBranchByID;

    public function view(?Branch $branch)
    {
        try
        {
            $branches = [];

            $index = 0;

            foreach($branch->get() as $s_branch)
            {
                $branches[$index++] = ['branch' => $s_branch->district];
            }

            Auth::check() && $branches[$index] = ['current_branch' => $this->Branch(auth()->user()->branch)->first()->district];

            return response($branches, 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The branches cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}