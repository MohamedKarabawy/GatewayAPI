<?php

namespace App\Users\Helpers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

trait UpdateUserEssentialData
{
    protected function UpdateUserEssentialData($user, Request $request, $class)
    {
        $request->has('branch') && $user->branch_id = $class->Branch($request->branch)->id;

        $request->has('full_name') && $user->full_name = $request->full_name;

        $request->has('email') && $user->email = $request->email;

        $request->has('password') && $user->password = Hash::make($request->password);

        foreach($class->permissions as $action)
        {
            $class->UserDataHelper($user, $request, $action, $class);
        }

        $user->save();

        return $user;
    }
}