<?php

namespace App\Users\Helpers;

trait UpdateUserAdditionalData
{
    protected function UpdateUserAdditionalData($UserMeta, $user_id, $request, $class)
    {
        if($request->has('phone_numbers'))
        {
            foreach($request->phone_numbers as $ph_key => $phone_number)
            {
                $UserMeta->where('user_id', $user_id)->where('meta_key', 'phone_number_'.$ph_key)->exists() ?

                    $class->UpdateMeta($UserMeta, 'user_id', $user_id, 'phone_number_'.$ph_key, $phone_number)
                    :
                    $class->CreateMeta($UserMeta, 'user_id', $user_id, 'phone_number_'.$ph_key, $phone_number);
            }
        }
 
        $request->has('personal_email') && ($UserMeta->where('user_id', $user_id)->where('meta_key', 'personal_email')->exists() ?

                $class->UpdateMeta($UserMeta, 'user_id', $user_id, 'personal_email', $request->personal_email)
                :
                $class->CreateMeta($UserMeta, 'user_id', $user_id, 'personal_email', $request->personal_email));
    }
}