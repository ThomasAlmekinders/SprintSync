<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVisibilitySettings extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id', 
        'show_email', 
        'show_phone', 
        'show_address', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
