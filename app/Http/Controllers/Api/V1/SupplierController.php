<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\SupplierApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function getAllSuppliersAndTheirRates(Request $request, SupplierApiService $supplierApiService): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'suppliers' => $supplierApiService->getAllSuppliersAndTheirRates(),
        ], 200);
    }

    /**
     * Display the user's profile form.
     */
    public function getAllOverlappingSuppliersAndTheirRates(Request $request, SupplierApiService $supplierApiService, ?int $supplier_id = null): JsonResponse
    {

        return response()->json([
            'status' => 'success',
            'supplier_rates' => $supplierApiService->getAllOverlappingSuppliersAndTheirRates($supplier_id),
        ], 200);
    }
}
