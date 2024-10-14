<?php

namespace App\Models;

use App\Models\Trainee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    
    // Table Name
    protected $table = 'gt_attendance';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        'class_id',
        'trainee_id',
        'admin_note',
        'trainer_note'
    ];

    public function trainees()
    {
            return $this->hasMany(Trainee::class, 'id', 'trainee_id');
    }
}