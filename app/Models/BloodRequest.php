<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    protected $fillable = [
        'patient_name',
        'patient_phone',
        'patient_email',
        'blood_group',
        'units_needed',
        'needed_by',
        'city',
        'hospital_name',
        'hospital_address',
        'medical_condition',
        'urgency',
        'status',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'needed_by' => 'date'
    ];
}
