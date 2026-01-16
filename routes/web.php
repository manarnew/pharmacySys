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
    
    // Search AJAX Endpoints
    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/products', [\App\Http\Controllers\Admin\SearchController::class, 'products'])->name('products');
        Route::get('/customers', [\App\Http\Controllers\Admin\SearchController::class, 'customers'])->name('customers');
        Route::get('/suppliers', [\App\Http\Controllers\Admin\SearchController::class, 'suppliers'])->name('suppliers');
        Route::get('/categories', [\App\Http\Controllers\Admin\SearchController::class, 'categories'])->name('categories');
        Route::get('/branches', [\App\Http\Controllers\Admin\SearchController::class, 'branches'])->name('branches');
    });

    Route::get('/customers', \App\Livewire\Admin\Customers\CustomerTable::class)->name('customers.index');
    Route::get('/customers/view', \App\Livewire\Admin\Customers\CustomerShow::class)->name('customers.show');
    Route::get('/users', \App\Livewire\Admin\Users\UserIndex::class)->name('users.index');
    Route::get('/branches', \App\Livewire\Admin\Branches\BranchIndex::class)->name('branches.index');
    Route::get('/suppliers', \App\Livewire\Admin\Suppliers\SupplierIndex::class)->name('suppliers.index');
    Route::get('/permissions', \App\Livewire\Admin\Permissions\PermissionIndex::class)->name('permissions.index');
    Route::get('/roles', \App\Livewire\Admin\Roles\RoleIndex::class)->name('roles.index');
    Route::get('/expenses', \App\Livewire\Admin\Expenses\ExpenseIndex::class)->name('expenses.index');

    
    // Pharmacy Management Routes
    Route::get('/products', \App\Livewire\Admin\Products\ProductIndex::class)->name('products.index');
    Route::get('/products/view', \App\Livewire\Admin\Products\ProductShow::class)->name('products.show');
    Route::get('/stores', \App\Livewire\Admin\Stores\StoreIndex::class)->name('stores.index');
    Route::get('/purchases', \App\Livewire\Admin\Purchases\PurchaseIndex::class)->name('purchases.index');
    Route::get('/purchases/return', \App\Livewire\Admin\Purchases\PurchaseReturnCreate::class)->name('purchases.return');
    Route::get('/sales', \App\Livewire\Admin\Sales\SaleIndex::class)->name('sales.index');
    Route::get('/sales/create', \App\Livewire\Admin\Sales\SaleCreate::class)->name('sales.create');
    Route::get('/sales/return', \App\Livewire\Admin\Sales\SaleReturnCreate::class)->name('sales.return');
    Route::get('/sales/{sale}/print', [\App\Http\Controllers\Admin\InvoiceController::class, 'print'])->name('sales.print');
    Route::get('/inventory/stocktake/create', App\Livewire\Admin\Inventory\StocktakeCreate::class)->name('stocktakes.create');
    Route::get('/inventory/stocktakes', App\Livewire\Admin\Inventory\StocktakeIndex::class)->name('stocktakes.index');
    Route::get('/inventory/stocktake/{stocktake}', App\Livewire\Admin\Inventory\StocktakeShow::class)->name('stocktakes.show');
    Route::get('/inventory', \App\Livewire\Admin\Inventory\InventoryIndex::class)->name('inventory.index');
});
