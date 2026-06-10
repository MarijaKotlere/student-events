<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isBlocked()
    {
        return $this->blocked == true;
    }
}