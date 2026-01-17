<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'opened_at',
        'closed_at',
        'opening_cash_balance',
        'opening_bank_balance',
        'expected_cash_balance',
        'expected_bank_balance',
        'actual_cash_balance',
        'actual_bank_balance',
        'cash_difference',
        'bank_difference',
        'notes',
        'status',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_cash_balance' => 'decimal:2',
        'opening_bank_balance' => 'decimal:2',
        'expected_cash_balance' => 'decimal:2',
        'expected_bank_balance' => 'decimal:2',
        'actual_cash_balance' => 'decimal:2',
        'actual_bank_balance' => 'decimal:2',
        'cash_difference' => 'decimal:2',
        'bank_difference' => 'decimal:2',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function cashMovements(): HasMany
    {
        return $this->hasMany(CashMovement::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function calculateExpectedBalances(): void
    {
        $cashTransactions = $this->paymentTransactions()
            ->where('payment_type', 'cash')
            ->sum('amount');
        
        $bankingAppTransactions = $this->paymentTransactions()
            ->where('payment_type', 'banking_app')
            ->sum('amount');

        $this->expected_cash_balance = $this->opening_cash_balance + $cashTransactions;
        $this->expected_bank_balance = $this->opening_bank_balance + $bankingAppTransactions;
        $this->save();
    }

    public function close(float $actualCash, float $actualBank, ?string $notes = null): void
    {
        $this->calculateExpectedBalances();
        
        $this->actual_cash_balance = $actualCash;
        $this->actual_bank_balance = $actualBank;
        $this->cash_difference = $actualCash - $this->expected_cash_balance;
        $this->bank_difference = $actualBank - $this->expected_bank_balance;
        $this->notes = $notes;
        $this->closed_at = now();
        $this->status = 'closed';
        
        $this->save();
    }
}
