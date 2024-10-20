<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'password',
        'profile_bio',
        'profile_picture',
        'is_administrator',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->username = (string) Str::uuid();
        });

        static::created(function ($user) {
            $user->address()->create([
                'street' => null,
                'house_number' => null,
                'city' => null,
                'postcode' => null,
                'country' => null,
            ]);
            $user->visibilitySettings()->create([
                'show_email' => false,
                'show_phone' => false,
                'show_address' => false,
            ]);
        });
    }

    public function visibilitySettings()
    {
        return $this->hasOne(UserVisibilitySettings::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }


    public function connections()
    {
        return $this->belongsToMany(User::class, 'user_connections', 'user_id', 'connected_user_id')
                    ->withTimestamps();
    }


    public function scrumboards()
    {
        return $this->belongsToMany(Scrumboard::class, 'scrumboard_user', 'user_id', 'scrumboard_id');
    }
}
