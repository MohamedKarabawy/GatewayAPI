<?php

namespace App\Traits;


trait GetTraineeMeta
{
    protected function meta($trainee, $meta_key)
    {
        return $trainee?->trainee_meta?->where('meta_key', $meta_key)?->first();
    }
}