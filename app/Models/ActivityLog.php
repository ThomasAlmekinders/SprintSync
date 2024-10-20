<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'log_name',
        'log_description',
        'ip_address',
        'user_agent',
    ];

    protected $dates = [
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
