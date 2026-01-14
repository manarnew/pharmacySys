<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Branch;
use App\Models\Expense;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalCustomers = 0;
    public $activeBranches = 0;
    public $totalExpenses = 0;
    public $totalUsers = 0;
    public $expenseStats = [];
    public $customerGrowth = [];

    public $startDate;
    public $endDate;
    public $selectedBranch;
    public $branches = [];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->branches = Branch::all();
        $this->loadStats();
    }

    public function filter()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalCustomers = Customer::query()
            ->when($this->selectedBranch, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'customers.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            })
            ->count();
            
        $this->activeBranches = Branch::count(); 
        
        $this->totalUsers = \App\Models\User::query()
            ->when($this->selectedBranch, fn($q) => $q->where('branch_id', $this->selectedBranch))
            ->count();
        
        $this->totalExpenses = Expense::query()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');

        // Daily Expenses
        $this->expenseStats = Expense::select(
            'date',
            \Illuminate\Support\Facades\DB::raw('SUM(amount) as total')
        )
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Customer Growth
        $this->customerGrowth = Customer::select(
            \Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'),
            \Illuminate\Support\Facades\DB::raw('COUNT(*) as count')
        )
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->when($this->selectedBranch, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'customers.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            })
            ->groupBy(\Illuminate\Support\Facades\DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
