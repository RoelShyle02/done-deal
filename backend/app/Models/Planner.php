<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planner extends Model
{
    use HasFactory;

    protected $table = 'planners';
    protected $guarded = [];


    public function user()
    {
        //by created_by

        return $this->belongsTo(User::class, 'created_by');
    }
}
