<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annoncement extends Model
{
    use HasFactory;

    // Table Name
    protected $table = ' gt_annoncements';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
     
    protected $fillable = [
        'user_id',
        'announce'
    ];
}
