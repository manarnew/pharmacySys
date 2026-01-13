<?php

namespace App\Livewire\Admin;

use App\Models\Patient;
use App\Models\Clinic;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Examination;
use App\Models\Prescription;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalPatients = 0;
    public $activeClinics = 0;
    public $totalOrders = 0;
    public $totalExpenses = 0;
    public $totalExams = 0;
    public $totalPrescriptions = 0;
    public $totalUsers = 0;
    public $expenseStats = [];
    public $patientGrowth = [];

    public $startDate;
    public $endDate;
    public $selectedClinic;
    public $clinics = [];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->clinics = Clinic::all();
        $this->loadStats();
    }

    public function filter()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $applyFilters = function ($q) {
            if ($this->startDate) {
                $q->whereDate('created_at', '>=', $this->startDate);
            }
            if ($this->endDate) {
                $q->whereDate('created_at', '<=', $this->endDate);
            }
            if ($this->selectedClinic) {
                $q->whereExists(function ($query) use ($q) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', $q->getModel()->getTable() . '.created_by')
                        ->where('users.clinic_id', $this->selectedClinic);
                });
            }
            return $q;
        };

        $this->totalPatients = Patient::query()
            ->when($this->selectedClinic, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'patients.created_by')
                        ->where('users.clinic_id', $this->selectedClinic);
                });
            })
            ->count();
            
        $this->activeClinics = Clinic::count(); 
        
        $this->totalUsers = \App\Models\User::query()
            ->when($this->selectedClinic, fn($q) => $q->where('clinic_id', $this->selectedClinic))
            ->count();

        $this->totalExams = $applyFilters(Examination::query())->count();
        $this->totalPrescriptions = $applyFilters(Prescription::query())->count();
        $this->totalOrders = $applyFilters(Order::query())->count();
        
        // Financials
        $this->outstandingBalance = $applyFilters(Order::query())->sum('balance');
        
        // Expenses (Special handling as it might not have created_by in mass assignment or date column is different)
        $expenseQuery = Expense::query()->whereBetween('date', [$this->startDate, $this->endDate]);
        // If Expense doesn't have created_by, we can't filter it by clinic easily unless it has clinic_id or we add created_by
        $this->totalExpenses = $expenseQuery->sum('amount');


        // Daily Expenses
        $this->expenseStats = Expense::select(
            'date',
            \Illuminate\Support\Facades\DB::raw('SUM(amount) as total')
        )
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Patient Growth
        $this->patientGrowth = Patient::select(
            \Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'),
            \Illuminate\Support\Facades\DB::raw('COUNT(*) as count')
        )
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->when($this->selectedClinic, function($q) {
                $q->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('users')
                        ->whereColumn('users.id', 'patients.created_by')
                        ->where('users.clinic_id', $this->selectedClinic);
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
