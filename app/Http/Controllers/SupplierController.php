<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierIdRequest;
use App\Http\Requests\SupplierPostRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Handles CRUD operation requests related to Suppliers
 */
class SupplierController extends Controller
{
    /**
     * Display the Supplier page that lists all the suppliers
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function getSupplierListView(Request $request): View
    {
        return view('supplier');
    }

    /**
     * Get the data that will be used in the Supplier page table list
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function getSupplierTableData(Request $request, SupplierService $supplierService): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'suppliers' => $supplierService->getAllSuppliersTableData(),
        ], 200);
    }

    /**
     * Create and add a new Supplier 
     * 
     * @param App\Http\Requests\SupplierPostRequest $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function addSupplier(SupplierPostRequest $request, SupplierService $supplierService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierService->addSupplier($data);

        return response()->json([
            'status' => $status,
        ], 200);
    }

    /**
     * Update an existing Supplier
     * 
     * @param App\Http\Requests\SupplierUpdateRequest $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function updateSupplier(SupplierUpdateRequest $request, SupplierService $supplierService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierService->updateSupplier($request->id, $data);

        return response()->json([
            'supplier_id' => $request->id,
            'status' => $status,
        ], 200);
    }

    /**
     * Delete a Supplier
     * 
     * @param App\Http\Requests\SupplierIdRequest $request
     * @param App\Services\SupplierService $supplierService
     * @return Illuminate\Http\JsonResponse
     */
    public function deleteSupplier(SupplierIdRequest $request, SupplierService $supplierService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierService->deleteSupplier($data['id']);

        return response()->json([
            'supplier_id' => $request->id,
            'status' => $status,
        ], 200);
    }
}
