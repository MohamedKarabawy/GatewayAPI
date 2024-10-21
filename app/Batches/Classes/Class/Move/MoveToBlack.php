<?php

namespace App\Batches\Classes\Class\Move;


use Exception;
use Carbon\Carbon;
use App\Models\Classes;
use App\Models\Trainee;
use App\Traits\GetList;
use App\Models\Attendance;
use App\Models\TraineeClass;
use Illuminate\Support\Facades\Gate;

class MoveToBlack
{
    use GetList;
    
    public function __construct(?Classes $class)
    {
        Gate::authorize('moveToBlack', $class);
        
        $this->list = 'Blacklist';

        $this->list_name = 'blacklist';
    }

    public function moveToBlack(?Trainee $trainees, ?TraineeClass $trainee_class, $class_id, $trainee_id)
    {
        try
        {
            $trainee = $trainees->where('id', $trainee_id)->first();

            $is_exists = $trainee_class->where("class_id", $class_id)->where("trainee_id", $trainee_id)->exists();
            
            if(($trainee->current_list !== $this->List($this->list)->id) && $is_exists)
            {
                $trainee_class->where("class_id", $class_id)->where("trainee_id", $trainee_id)->delete();

                Attendance::where("class_id", $class_id)->where("trainee_id", $trainee_id)->delete();

                $trainee->pervious_list = $trainee->current_list;
                
                $trainee->current_list = $this->List($this->list)->id;

                $trainee->moved_date = Carbon::now();
    
                $trainee->save();
    
                return response(['message' => "Trainee moved to ".$this->list_name." successfully."], 200);
            }
    
            return response(['message' => "Trainee is already in ".$this->list_name."."], 400);
        }
        catch (Exception $e)
        {
            return response(['message' => "Something went wrong. Trainee be moved to wait list. Please contact the administrator of the website."], 400);
        }
    }
}