<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrumboardSprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'scrumboard_id', 
        'name', 
        'description',
        'planned_start_date', 
        'planned_end_date', 
        'sprint_order',
    ];

    protected $casts = [
        'planned_start_date' => 'datetime',
        'planned_end_date' => 'datetime',
    ];

    public function scrumboard()
    {
        return $this->belongsTo(Scrumboard::class, 'scrumboard_id');
    }

    public function tasks()
    {
        return $this->hasMany(ScrumboardTask::class, 'sprint_id');
    }
}
