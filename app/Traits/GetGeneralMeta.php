<?php

namespace App\Traits;

use App\Models\GeneralMeta;

trait GetGeneralMeta
{
    protected function GetGeneralMeta($id)
    {
        return GeneralMeta::where('id', $id)->first();
    }
}