<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_no',
        'patient_id',
        'prescription_id',
        'frame_type',
        'lens_index',
        'lens_type',
        'photo',
        'package',
        'destination',
        'notes',
        'status',
        'total_amount',
        'paid_amount',
        'balance',
        'discount',
        'created_by',
        'updated_by',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
