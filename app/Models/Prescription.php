<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'examination_id',
        'sphere_od',
        'cyl_od',
        'axis_od',
        'add_od',
        'va_od',
        'sphere_os',
        'cyl_os',
        'axis_os',
        'add_os',
        'va_os',
        'ipd',
        'notes',
        'specialist_id',
        'created_by',

        'updated_by',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}

