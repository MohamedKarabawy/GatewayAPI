<?php

namespace App\Traits;

use App\Models\User;

trait GetUser
{
    protected function User($id)
    {
        return User::where('id', $id)->first();
    }
}