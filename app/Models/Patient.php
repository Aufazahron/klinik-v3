<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = [
        'tenant_id',
        'medical_record_number',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'phone',
        'address',
        'national_id',
        'family_card_number',
        'marital_status',
        'registered_at',
        'external_id',
        'is_active',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'registered_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function insurances()
    {
        return $this->hasMany(PatientInsurance::class);
    }

    public function primaryInsurance()
    {
        return $this->hasOne(PatientInsurance::class)->where('active', true);
    }
}
