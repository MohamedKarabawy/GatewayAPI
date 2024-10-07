<?php

namespace App\Traits;

use App\Models\Gtlist;

trait GetList
{
    protected function List($list_title)
    {
        return Gtlist::where('list_title', $list_title)->first();
    }
}