<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Practitioner extends Authenticatable
{
    use Notifiable;

    protected $table = 'practitioners';

    protected $fillable = [
        'tenant_id',
        'full_name',
        'identifier',
        'role',
        'phone',
        'email',
        'password',
        'external_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // alias "name" supaya tetap kompatibel dengan view yang mungkin pakai $user->name
    public function getNameAttribute()
    {
        return $this->full_name;
    }
}

