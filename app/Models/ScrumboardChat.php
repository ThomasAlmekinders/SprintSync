<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrumboardChat extends Model
{
    use HasFactory;

    protected $table = 'scrumboard_chat';
    
    protected $fillable = [
        'user_id', 
        'scrumboard_id', 
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scrumboard()
    {
        return $this->belongsTo(Scrumboard::class);
    }
}
