<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRateIdRequest;
use App\Http\Requests\SupplierRatePostRequest;
use App\Http\Requests\SupplierRateUpdateRequest;
use App\Services\SupplierRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Handles CRUD operation requests related to Supplier Rates
 */
class SupplierRateController extends Controller
{
    /**
     * Display the Supplier Rate page that lists all the suppliers
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function getSupplierRateListView(Request $request): View
    {
        return view('supplier_rate');
    }

    /**
     * Get the data that will be used in the Supplier Rate page table list
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function getSupplierRateTableData(Request $request, SupplierRateService $supplierRateService): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'supplier_rates' => $supplierRateService->getAllSupplierRatesTableData(),
            'supplier_list' => $supplierRateService->getAllSuppliersForSelect(),
        ], 200);
    }

    /**
     * Create and add a new Supplier Rate
     * 
     * @param App\Http\Requests\SupplierRatePostRequest $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function addSupplierRate(SupplierRatePostRequest $request, SupplierRateService $supplierRateService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierRateService->addSupplierRate($data);

        return response()->json([
            'status' => $status,
        ], 200);
    }

    /**
     * Update an existing Supplier Rate
     * 
     * @param App\Http\Requests\SupplierRateUpdateRequest $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function updateSupplierRate(SupplierRateUpdateRequest $request, SupplierRateService $supplierRateService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierRateService->updateSupplierRate($request->id, $data);

        return response()->json([
            'supplier_rate_id' => $request->id,
            'status' => $status,
        ], 200);
    }

    /**
     * Delete a Supplier Rate
     * 
     * @param App\Http\Requests\SupplierRateIdRequest $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function deleteSupplierRate(SupplierRateIdRequest $request, SupplierRateService $supplierRateService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierRateService->deleteSupplierRate($data['id']);

        return response()->json([
            'supplier_rate_id' => $request->id,
            'status' => $status,
        ], 200);
    }
}
