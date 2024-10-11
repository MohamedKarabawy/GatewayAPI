<?php

namespace App\Traits;

use App\Models\Branch;

trait GetBranchByID
{
    protected function Branch($id)
    {
        return Branch::find($id);
    }
}