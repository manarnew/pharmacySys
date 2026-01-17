<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'sale_id',
        'shift_id',
        'payment_type',
        'amount',
        'transaction_number',
        'sender_name',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeCash($query)
    {
        return $query->where('payment_type', 'cash');
    }

    public function scopeBankingApp($query)
    {
        return $query->where('payment_type', 'banking_app');
    }

    public function scopeForShift($query, $shiftId)
    {
        return $query->where('shift_id', $shiftId);
    }

    // Methods
    public function canDelete(): bool
    {
        return $this->shift && $this->shift->status === 'open';
    }
}
