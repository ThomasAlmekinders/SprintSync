<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Scrumboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'active',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'scrumboard_user')->withTimestamps();
    }

    public function sprints()
    {
        return $this->hasMany(ScrumboardSprint::class, 'scrumboard_id');
    }

    public function chats()
    {
        return $this->hasMany(ScrumboardChat::class);
    }

}
