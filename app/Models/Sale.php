<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_no',
        'sale_date',
        'subtotal',
        'discount',
        'tax',
        'total',
        'payment_status',
        'payment_type',
        'paid_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function returns(): HasMany
    {
        return $this->hasMany(SaleReturn::class);
    }

    // Calculate totals
    public function calculateTotals()
    {
        $this->subtotal = $this->items()->sum('total');
        $this->tax = ($this->subtotal - $this->discount) * 0; // Can be customized
        $this->total = $this->subtotal - $this->discount + $this->tax;
        $this->save();
    }

    // Get remaining balance
    public function getRemainingBalanceAttribute()
    {
        return $this->total - $this->paid_amount;
    }
}
