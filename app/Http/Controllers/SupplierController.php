<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierIdRequest;
use App\Http\Requests\SupplierPostRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function getSupplierListView(Request $request): View
    {
        return view('supplier');
    }

    /**
     * Display the user's profile form.
     */
    public function getSupplierTableData(Request $request, SupplierService $supplierService): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'suppliers' => $supplierService->getAllSuppliersTableData(),
        ], 200);
    }

    /**
     * Display the user's profile form.
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
     * Display the user's profile form.
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
     * Display the user's profile form.
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
