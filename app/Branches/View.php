<?php

namespace App\Branches;

use App\Models\Branch;
use Exception;

class View
{
    public function view(?Branch $branch)
    {
        try
        {
            $branches = [];

            foreach($branch->get() as $key => $s_branch)
            {
                $branches[$key] = ['branch' => $s_branch->district];
            }

            return response(['branches' => $branches], 201);
        }
        catch(Exception $e)
        {
            return response(['message' => "Something went wrong. The branches cannot be viewed. Please contact the administrator of the website."], 400);
        }
    }
}