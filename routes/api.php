<?php

use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// create token
Route::post('/create-token', [UserController::class, 'createToken']);

// supplier api
Route::get('/v1/suppliers', [SupplierController::class, 'getAllSuppliersAndTheirRates'])->middleware('auth:sanctum');

Route::get('/v1/overlapping-suppliers/{supplier_id?}', [SupplierController::class, 'getAllOverlappingSuppliersAndTheirRates'])->where('supplier_id', '[0-9]+')
    ->middleware('auth:sanctum');

// fallback
Route::fallback(function () {
    return response()->json([
        'error' => 'Invalid Request',
    ], 404);
});
