<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\SupplierApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Handles API requests 
 */
class SupplierController extends Controller
{
    /**
     * Fetches all the suppliers and their rates
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Services\SupplierApiService $supplierApiService
     * @return Illuminate\Http\JsonResponse 
     */
    public function getAllSuppliersAndTheirRates(Request $request, SupplierApiService $supplierApiService): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'suppliers' => $supplierApiService->getAllSuppliersAndTheirRates(),
        ], 200);
    }

    /**
     * Fetches all the overlapping suppliers rates
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Services\SupplierApiService $supplierApiService
     * @param Int $supplier_id | Overlapping supplier id
     * @return Illuminate\Http\JsonResponse 
     */
    public function getAllOverlappingSuppliersAndTheirRates(Request $request, SupplierApiService $supplierApiService, ?int $supplier_id = null): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'supplier_rates' => $supplierApiService->getAllOverlappingSuppliersAndTheirRates($supplier_id),
        ], 200);
    }
}
