<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInsurance extends Model
{
    protected $table = 'patient_insurances';

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'insurance_id',
        'member_number',
        'class',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
}
