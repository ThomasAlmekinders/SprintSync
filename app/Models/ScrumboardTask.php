<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrumboardTask extends Model
{
    use HasFactory;

    protected $fillable = ['sprint_id', 'title', 'description', 'status', 'finished_at'];

    public function sprint()
    {
        return $this->belongsTo(ScrumboardSprint::class, 'sprint_id');
    }
}
