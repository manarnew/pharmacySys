<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'store_id',
        'product_id',
        'batch_no',
        'expiry_date',
        'quantity',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Check if batch is expired
    public function isExpired(): bool
    {
        return $this->expiry_date < now();
    }

    // Check if batch is expiring soon (within 3 months)
    public function isExpiringSoon(): bool
    {
        return $this->expiry_date <= now()->addMonths(3) && !$this->isExpired();
    }
}
