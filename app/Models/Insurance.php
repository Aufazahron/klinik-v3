<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $table = 'insurances';

    protected $fillable = [
        'tenant_id',
        'name',
        'type',
        'contact_info',
        'external_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
