<?php

namespace App\Trainees\Helpers;


trait ListChangerHelper
{
    protected function listChanger($trainee, $class, $id)
    {   
        if($trainee->current_list !== $class->List($class->list)->id)
        {
            $trainee->pervious_list = $trainee->current_list;
            
            $trainee->current_list = $class->List($class->list)->id;

            $trainee->save();

            return response(['message' => "Trainee moved to ".$class->list_name." successfully."], 201);
        }

        return response(['message' => "Trainee is already in ".$class->list_name."."], 400);

    }
}