<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Patients\PatientTable;


// Logout

// Admin routes (protected) - ONLY 2 ROUTES
// Dashboard
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/patients', PatientTable::class)->name('patients.index');
    Route::get('/patients/view', \App\Livewire\Admin\Patients\PatientShow::class)->name('patients.show');
    Route::get('/users', \App\Livewire\Admin\Users\UserIndex::class)->name('users.index');
    Route::get('/clinics', \App\Livewire\Admin\Clinics\ClinicIndex::class)->name('clinics.index');
    Route::get('/examinations', \App\Livewire\Admin\Examinations\ExaminationIndex::class)->name('examinations.index');
    Route::get('/examinations/edit', \App\Livewire\Admin\Examinations\ExaminationEdit::class)->name('examinations.edit');
    Route::get('/prescriptions', \App\Livewire\Admin\Prescriptions\PrescriptionIndex::class)->name('prescriptions.index');
    Route::get('/orders', \App\Livewire\Admin\Orders\OrderIndex::class)->name('orders.index');
    Route::get('/suppliers', \App\Livewire\Admin\Suppliers\SupplierIndex::class)->name('suppliers.index');
    Route::get('/permissions', \App\Livewire\Admin\Permissions\PermissionIndex::class)->name('permissions.index');
    Route::get('/expenses', \App\Livewire\Admin\Expenses\ExpenseIndex::class)->name('expenses.index');
    Route::get('/messages', \App\Livewire\Admin\Messages\MessageIndex::class)->name('messages.index');
});
