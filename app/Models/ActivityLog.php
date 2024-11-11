<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ActivityLog extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'log_name',
        'log_description',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $dates = [
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
