<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gtlist;
use App\Models\Branch;
use App\Models\TraineeMeta;

class Trainee extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'gt_trainees';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "follow_up",
        "trainer_id",
        'branch_id',
        'full_name',
        'notes',
        'attend_type',
        "level",
        "payment_type",
        "preferable_time",
    ];

    public function list()
    {
        return $this->belongsTo(Gtlist::class, 'current_list', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function trainee_meta()
    {
        return $this->hasMany(TraineeMeta::class, 'trainee_id', 'id');
    }
}