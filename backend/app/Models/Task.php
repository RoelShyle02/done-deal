<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $guarded = [];


    // public function planner()
    // {
    //     //by planner_guid

    //     return $this->belongsTo(Planner::class, 'planner_guid');
    // }
}
