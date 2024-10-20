<?php

namespace App\Traits;

use App\Models\GtList;

trait GetListById
{
    protected function List($id)
    {
        return GtList::where('id', $id)->first();
    }
}