<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $table = 'encounters';

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'practitioner_id',
        'department_id',
        'encounter_datetime',
        'encounter_status',
        'encounter_code',
        'chief_complaint',
        'external_id',
        'is_active',
    ];

    protected $casts = [
        'encounter_datetime' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function practitioner()
    {
        return $this->belongsTo(Practitioner::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
