<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierRateController;
use Illuminate\Support\Facades\Route;

// profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// supplier routes
Route::get('/supplier', [SupplierController::class, 'getSupplierListView'])->middleware(['auth', 'verified'])->name('supplier');
Route::get('/supplier-table-data', [SupplierController::class, 'getSupplierTableData'])->middleware(['auth', 'verified'])->name('supplier_table_data');
Route::post('/supplier-add', [SupplierController::class, 'addSupplier'])->middleware(['auth', 'verified'])->name('supplier_add');
Route::put('/supplier-update/{id}', [SupplierController::class, 'updateSupplier'])->middleware(['auth', 'verified'])->name('supplier_update')->where('id', '[0-9]+');
Route::delete('/supplier-delete/{id}', [SupplierController::class, 'deleteSupplier'])->middleware(['auth', 'verified'])->name('supplier_delete')->where('id', '[0-9]+');

// supplier rate routes
Route::get('/supplier-rate', [SupplierRateController::class, 'getSupplierRateListView'])->middleware(['auth', 'verified'])->name('supplier_rate');
Route::get('/supplier-rate-table-data', [SupplierRateController::class, 'getSupplierRateTableData'])->middleware(['auth', 'verified'])->name('supplier_rate_table_data');
Route::post('/supplier-rate-add', [SupplierRateController::class, 'addSupplierRate'])->middleware(['auth', 'verified'])->name('supplier_rate_add');
Route::put('/supplier-rate-update/{id}', [SupplierRateController::class, 'updateSupplierRate'])->middleware(['auth', 'verified'])->name('supplier_rate_update')->where('id', '[0-9]+');
Route::delete('/supplier-rate-delete/{id}', [SupplierRateController::class, 'deleteSupplierRate'])->middleware(['auth', 'verified'])->name('supplier_rate_delete')->where('id', '[0-9]+');

require __DIR__.'/auth.php';
