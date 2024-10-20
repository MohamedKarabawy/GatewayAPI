<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'gt_classes';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
     
    protected $fillable = [
        'user_id',
        'batch_id',
        'trainer_id',
        'class_name',
        'class_type',
        'gate',
        'time_slot',
        'level',
        'gate_url',
        'gate_password'
    ];
}