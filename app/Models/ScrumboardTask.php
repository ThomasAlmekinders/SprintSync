<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrumboardTask extends Model
{
    use HasFactory;

    //public static $status = ["to_do", "in_progress", "done"];

    protected $fillable = [
        'sprint_id', 
        'title', 
        'description', 
        'status', 
        'finished_at',
        'task_order',
    ];

    public function sprint()
    {
        return $this->belongsTo(ScrumboardSprint::class, 'sprint_id');
    }
}
