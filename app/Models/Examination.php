<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'sphere_rd', 'cylinder_rd', 'axis_rd', 'va_rd',
        'sphere_ld', 'cylinder_ld', 'axis_ld', 'va_ld',
        'sphere_rn', 'cylinder_rn', 'axis_rn', 'va_rn',
        'sphere_ln', 'cylinder_ln', 'axis_ln', 'va_ln',
        'pd', 'notes',
        'history', 'specialist_id',
        'old_sphere_od', 'old_cyl_od', 'old_axis_od', 'old_add_od', 'old_va_od',

        'old_sphere_os', 'old_cyl_os', 'old_axis_os', 'old_add_os', 'old_va_os',
        'subj_sphere_od', 'subj_cyl_od', 'subj_axis_od', 'subj_add_od', 'subj_va_od',
        'subj_sphere_os', 'subj_cyl_os', 'subj_axis_os', 'subj_add_os', 'subj_va_os',
        'created_by', 'updated_by'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}

