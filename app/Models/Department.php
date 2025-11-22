<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'tenant_id',
        'name',
        'code',
        'description',
        'is_active',
        'organization_id',
        'location_id',
        'external_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

