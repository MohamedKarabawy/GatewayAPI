<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeMeta extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'gt_trainee_metas';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
     
    protected $fillable = [
        'trainee_id',
        'meta_key',
        'meta_value'
    ];
}
