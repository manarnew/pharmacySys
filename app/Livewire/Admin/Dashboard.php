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
    public $totalSales = 0;
    public $totalPurchases = 0;
    public $lowStockCount = 0;
    public $recentSales = [];
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

        // New Metrics: Sales & Purchases
        $this->totalSales = \App\Models\Sale::query()
            ->whereBetween('sale_date', [$this->startDate, $this->endDate])
            ->when($this->selectedBranch, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'sales.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            })
            ->sum('total');

        $this->totalPurchases = \App\Models\Purchase::query()
            ->whereBetween('purchase_date', [$this->startDate, $this->endDate])
            ->sum('total');

        $this->lowStockCount = \App\Models\Product::whereRaw('(select COALESCE(SUM(quantity), 0) from inventories where product_id = products.id) < reorder_level')
            ->count();

        $this->recentSales = \App\Models\Sale::with('customer')
            ->when($this->selectedBranch, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'sales.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            })
            ->latest()
            ->limit(5)
            ->get();

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
