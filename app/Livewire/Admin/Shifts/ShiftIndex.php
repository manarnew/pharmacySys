<?php

namespace App\Livewire\Admin\Shifts;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;

class ShiftIndex extends Component
{
    public $openingCashBalance = 0;
    public $openingBankBalance = 0;
    public $showOpenModal = false;
    public $showCloseModal = false;
    public $actualCashBalance = 0;
    public $actualBankBalance = 0;
    public $closingNotes = '';

    public function openShift()
    {
        // Check if user already has an open shift
        $existingShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if ($existingShift) {
            session()->flash('error', __('You already have an open shift'));
            return;
        }

        $this->validate([
            'openingCashBalance' => 'required|numeric|min:0',
            'openingBankBalance' => 'required|numeric|min:0',
        ]);

        Shift::create([
            'user_id' => auth()->id(),
            'branch_id' => auth()->user()->branch_id ?? null,
            'opened_at' => now(),
            'opening_cash_balance' => $this->openingCashBalance,
            'opening_bank_balance' => $this->openingBankBalance,
            'expected_cash_balance' => $this->openingCashBalance,
            'expected_bank_balance' => $this->openingBankBalance,
            'status' => 'open',
        ]);

        session()->flash('success', __('Shift opened successfully'));
        $this->showOpenModal = false;
        $this->reset(['openingCashBalance', 'openingBankBalance']);
    }

    public function prepareClose()
    {
        $currentShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if (!$currentShift) {
            session()->flash('error', __('No open shift found'));
            return;
        }

        // Calculate expected balances
        $currentShift->calculateExpectedBalances();

        // Pre-fill with expected values
        $this->actualCashBalance = $currentShift->expected_cash_balance;
        $this->actualBankBalance = $currentShift->expected_bank_balance;
        
        $this->showCloseModal = true;
    }

    public function closeShift()
    {
        $this->validate([
            'actualCashBalance' => 'required|numeric',
            'actualBankBalance' => 'required|numeric',
        ]);

        $currentShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->first();

        if (!$currentShift) {
            session()->flash('error', __('No open shift found'));
            return;
        }

        DB::transaction(function () use ($currentShift) {
            $currentShift->close(
                $this->actualCashBalance,
                $this->actualBankBalance,
                $this->closingNotes
            );
        });

        session()->flash('success', __('Shift closed successfully'));
        $this->showCloseModal = false;
        $this->reset(['actualCashBalance', 'actualBankBalance', 'closingNotes']);
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $currentShift = Shift::where('user_id', auth()->id())
            ->where('status', 'open')
            ->with('paymentTransactions')
            ->first();

        $shifts = Shift::where('user_id', auth()->id())
            ->orderBy('opened_at', 'desc')
            ->paginate(15);

        return view('livewire.admin.shifts.shift-index', [
            'currentShift' => $currentShift,
            'shifts' => $shifts,
        ]);
    }
}
