<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Admin\Dashboard;



// Redirection from root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Admin routes (protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/customers', \App\Livewire\Admin\Customers\CustomerTable::class)->name('customers.index');
    Route::get('/customers/view', \App\Livewire\Admin\Customers\CustomerShow::class)->name('customers.show');
    Route::get('/users', \App\Livewire\Admin\Users\UserIndex::class)->name('users.index');
    Route::get('/branches', \App\Livewire\Admin\Branches\BranchIndex::class)->name('branches.index');
    Route::get('/suppliers', \App\Livewire\Admin\Suppliers\SupplierIndex::class)->name('suppliers.index');
    Route::get('/permissions', \App\Livewire\Admin\Permissions\PermissionIndex::class)->name('permissions.index');
    Route::get('/roles', \App\Livewire\Admin\Roles\RoleIndex::class)->name('roles.index');
    Route::get('/expenses', \App\Livewire\Admin\Expenses\ExpenseIndex::class)->name('expenses.index');
    Route::get('/messages', \App\Livewire\Admin\Messages\MessageIndex::class)->name('messages.index');
});
