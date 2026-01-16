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

    // Today's Stats
    public $todaySales = 0;
    public $todayTransactions = 0;
    public $todayExpenses = 0;
    public $todayNetCash = 0;
    public $newCustomersToday = 0;
    public $topProductsToday = [];

    // Stocktake Stats
    public $pendingStocktakesCount = 0;
    public $approvedStocktakesCount = 0;
    public $rejectedStocktakesCount = 0;
    public $recentStocktakes = [];

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
        // ... (Existing Code) ...

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
        $salesQuery = \App\Models\Sale::query()
            ->whereBetween('sale_date', [$this->startDate, $this->endDate])
            ->when($this->selectedBranch, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'sales.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            });

        $this->totalSales = (clone $salesQuery)->sum('total');

        $this->totalPurchases = \App\Models\Purchase::query()
            ->whereBetween('purchase_date', [$this->startDate, $this->endDate])
            ->sum('total');

        $this->lowStockCount = \App\Models\Product::whereRaw('(select COALESCE(SUM(quantity), 0) from inventories where product_id = products.id) < reorder_level')
            ->count();

        // ---------------------------------------------
        // Today's Highlights Calculation
        // ---------------------------------------------
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        // Today's Sales Query
        $todaySalesQuery = \App\Models\Sale::query()
            ->whereBetween('sale_date', [$todayStart, $todayEnd])
            ->when($this->selectedBranch, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'sales.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            });

        $this->todaySales = (clone $todaySalesQuery)->sum('total');
        $this->todayTransactions = (clone $todaySalesQuery)->count();

        // Today's Expenses
        $this->todayExpenses = Expense::query()
            ->whereDate('date', now()->today())
            ->sum('amount');

        $this->todayNetCash = $this->todaySales - $this->todayExpenses;

        // New Customers Today
        $this->newCustomersToday = Customer::query()
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->when($this->selectedBranch, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'customers.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            })
            ->count();

        // Top 5 Products Today
        $this->topProductsToday = \App\Models\SaleItem::query()
            ->select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'), \Illuminate\Support\Facades\DB::raw('SUM(total) as total_revenue'))
            ->whereHas('sale', function($q) use ($todayStart, $todayEnd) {
                $q->whereBetween('sale_date', [$todayStart, $todayEnd])
                  ->when($this->selectedBranch, function($subQ) {
                      $subQ->whereExists(function ($query) {
                          $query->select(\Illuminate\Support\Facades\DB::raw(1))
                              ->from('users')
                              ->whereColumn('users.id', 'sales.created_by')
                              ->where('users.branch_id', $this->selectedBranch);
                      });
                  });
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product') // Eager load product name
            ->limit(5)
            ->get();

        // ---------------------------------------------
        // Stocktake Stats
        // ---------------------------------------------
        $stocktakeQuery = \App\Models\Stocktake::query()
            ->when($this->selectedBranch, function($q) {
                // Stocktakes are directly linked to store, which belongs to branch?
                // Wait, Store model doesn't explicitly guarantee branch link in this codebase yet?
                // However, the `created_by` user DOES have a branch. Let's use that for consistency.
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'stocktakes.created_by')
                        ->where('users.branch_id', $this->selectedBranch);
                });
            });

        $this->pendingStocktakesCount = (clone $stocktakeQuery)->where('status', 'pending_approval')->count();
        $this->approvedStocktakesCount = (clone $stocktakeQuery)->where('status', 'completed')->count(); // Completed = Approved
        $this->rejectedStocktakesCount = (clone $stocktakeQuery)->where('status', 'rejected')->count();

        $this->recentStocktakes = (clone $stocktakeQuery)
            ->with(['creator', 'store'])
            ->latest()
            ->limit(5)
            ->get();

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
