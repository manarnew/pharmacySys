<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'store_id',
        'type',
        'reference_type',
        'reference_id',
        'batch_no',
        'quantity_in',
        'quantity_out',
        'balance',
        'notes',
        'created_by',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Get the related reference model (Purchase, Sale, etc.)
    public function reference()
    {
        return $this->morphTo();
    }
}
